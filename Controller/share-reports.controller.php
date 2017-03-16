<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Controller Sharing Report
 * @version 2.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

//View
WPUSB_App::uses( 'share-report', 'View' );

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

if ( ! class_exists( 'WP_Screen' ) ) {
	WPUSB_Utils::include_file_screen();
}

if ( ! class_exists( 'Walker_Category_Checklist' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/template.php' );
}

class WPUSB_Share_Reports_Controller extends WP_List_Table {

	/**
	 * Number for posts per page
	 *
	 * @since 1.1
	 * @var Integer
	 */
	const POSTS_PER_PAGE = 15;

	/**
	 * Number for cache time
	 *
	 * @since 1.2
	 * @var Integer
	 */
	private $cache_time;

	/**
	 * Search in list table
	 *
	 * @since 1.2
	 * @var string
	 */
	private $search;

	/**
	 * Table name
	 *
	 * @since 3.32
	 * @var string
	 */
	private $table;

	/**
	 * Tag prefix
	 *
	 * @since 3.32
	 * @var string
	 */
	public $tag = '_sharing_report_';

	/**
	 * Month filter
	 *
	 * @since 3.32
	 * @var Integer
	 */
	private $m;

	public function __construct() {
		$this->_set_property();

		add_action( 'admin_menu', array( $this, 'menu' ) );

		parent::__construct( array(
			'singular' => 'social-share-report',
			'plural'   => 'social-sharing-reports',
			'screen'   => WPUSB_Utils::add_prefix( '_sharing_report' ),
			'ajax'     => false,
		) );
	}

	private function _set_property() {
		$this->search     = WPUSB_Utils::get( 's', false, 'esc_sql' );
		$this->cache_time = WPUSB_Utils::option( 'report_cache_time', 10, 'intval' );
		$this->table      = WPUSB_Utils::get_table_name();
		$this->m          = WPUSB_Utils::get( 'm', 0, 'intval' );
	}

	/**
	 * Create submenu page
	 *
	 * @since 1.0
	 * @param null
	 * @return Void
	 */
	public function menu() {
	  	add_submenu_page(
	  		WPUSB_App::SLUG,
	  		__( 'Sharing Report | WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ),
	  		__( 'Sharing Report', WPUSB_App::TEXTDOMAIN ),
	  		'manage_options',
	  		WPUSB_Setting::SHARING_REPORT,
	  		array( $this, 'report' )
	  	);
	}

	/**
	 * Search in database results relative share posts
	 *
	 * @since 1.4
	 * @global $wpdb
	 * @param Int $page
	 * @param String $orderby
	 * @param String $order
	 * @return Object
	 */
	private function _get_sharing_report( $posts_per_page, $current_page, $orderby, $order ) {
		global $wpdb;

		$offset = ( ( $current_page - 1 ) * self::POSTS_PER_PAGE );
		$cache  = get_transient( WPUSB_Setting::TRANSIENT_SHARING_REPORT );
		$where  = apply_filters( WPUSB_Utils::add_prefix( $this->tag . 'where' ), $this->_where() );

		if ( ! $this->_table_exists( $wpdb ) ) {
			return;
		}

		if ( ! $this->_is_filter() && false !== $cache && isset( $cache[ $current_page ][ $orderby ][ $order ] ) ) {
			return $cache[ $current_page ][ $orderby ][ $order ];
		}

		$query = $wpdb->prepare(
			"SELECT * FROM
				`{$this->table}`
			 {$where}
			 ORDER BY
			 	`{$orderby}` {$order}
			 LIMIT
			 	%d OFFSET %d
			",
			$posts_per_page,
			$offset
		);

		$results                                      = $wpdb->get_results( $query );
		$cache[ $current_page ][ $orderby ][ $order ] = $results;

		if ( ! $this->_is_filter() ) {
			set_transient(
				WPUSB_Setting::TRANSIENT_SHARING_REPORT,
				$cache,
				$this->cache_time * MINUTE_IN_SECONDS
			);
		}

		return $results;
	}

	/**
	 * Get total results in wp list table for records
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param Null
	 * @return Integer
	 */
	private function _total_items() {
		global $wpdb;

		$cache = get_transient( WPUSB_Setting::TRANSIENT_SHARING_REPORT_COUNT );

		if ( ! $this->_table_exists( $wpdb ) ) {
			return 0;
		}

		if ( ! $this->_is_filter() && false !== $cache ) {
			return $cache;
		}

		$where = apply_filters(
			WPUSB_Utils::add_prefix( $this->tag . 'where_count' ),
			$this->_where()
		);

		$query       = "SELECT COUNT(*) FROM {$this->table} {$where}";
		$row_count   = $wpdb->get_var( $query );
		$total_items = intval( $row_count );

		$this->_set_cache_caunter( $total_items );

		return $total_items;
	}

	/**
	 * Create sql where post title for search
	 *
	 * @since 1.0
	 * @param String $space
	 * @return Mixed Null|String
	 */
	private function _where() {
		global $wpdb;

		$search = $wpdb->esc_like( $this->search );
		$where  = '';

		if ( ! empty( $search ) ) {
			$where .= " `post_title` LIKE '%%{$search}%%'";
		}

		if ( $this->m ) :
			$and    = ( $where ) ? ' AND' : '';
			$where .= sprintf( '%s YEAR( `post_date` ) = %s', $and, substr( $this->m, 0, 4 ) );
			$where .= sprintf( ' AND MONTH( `post_date` ) = %s', substr( $this->m, 4, 2 ) );
		endif;

		return ( $where ) ? 'WHERE' . $where : '';
	}

	/**
	 * Verify table exists in database
	 *
	 * @since 1.0
	 * @param Object $wpdb
	 * @return Boolean
	 */
	private function _table_exists( $wpdb ) {
		return $wpdb->query( "SHOW TABLES LIKE '{$this->table}'" );
	}

	/**
	 * Set transient cache items counter
	 *
	 * @since 1.0
	 * @param Integer $total_items
	 * @return Void
	 */
	private function _set_cache_caunter( $total_items ) {
		if ( ! $this->_is_filter() ) {
			set_transient(
				WPUSB_Setting::TRANSIENT_SHARING_REPORT_COUNT,
				$total_items,
				$this->cache_time * MINUTE_IN_SECONDS
			);
		}
	}

	private function _is_filter() {
		$is_filter = ( $this->search || $this->m );

		return apply_filters( WPUSB_Utils::add_prefix( $this->tag . 'is_filter' ), $is_filter );
	}

	/**
	 * Insert results in column wp list table
	 *
	 * @since 1.0
	 * @param Object $item
	 * @param String $column
	 * @return Mixed String|Int
	 */
	public function column_default( $item, $column ) {
		$column = strtolower( $column );

		switch ( $column ) {
			case 'title' :
				return WPUSB_Sharing_Report_View::get_permalink_title( $item );

			case 'facebook'  :
			case 'twitter'   :
			case 'google'    :
			case 'linkedin'  :
			case 'pinterest' :
			case 'tumblr'    :
			case 'buffer'    :
			case 'total'     :
				return WPUSB_Utils::number_format( $item->{$column} );

			case 'date' :
				return esc_attr( date_i18n( __( 'Y/m/d g:i:s a' ), strtotime( $item->post_date ) ) );
		}
	}

	/**
	 * Set column wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	public function get_columns() {
		$columns = array(
			'Title'     => __( 'Title', WPUSB_App::TEXTDOMAIN ),
			'Facebook'  => __( 'Facebook', WPUSB_App::TEXTDOMAIN ),
			'Google'    => __( 'Google+', WPUSB_App::TEXTDOMAIN ),
			'Twitter'   => __( 'Twitter', WPUSB_App::TEXTDOMAIN ),
			'Linkedin'  => __( 'Linkedin', WPUSB_App::TEXTDOMAIN ),
			'Pinterest' => __( 'Pinterest', WPUSB_App::TEXTDOMAIN ),
			'Tumblr'    => __( 'Tumblr', WPUSB_App::TEXTDOMAIN ),
			'Buffer'    => __( 'Buffer', WPUSB_App::TEXTDOMAIN ),
			'Total'     => __( 'Total', WPUSB_App::TEXTDOMAIN ),
			'Date'      => __( 'Post date', WPUSB_App::TEXTDOMAIN ),
		);

		return $columns;
	}

	/**
	 * Set orderby in column wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'Title'     => array( 'post_title', true ),
			'Facebook'  => array( 'facebook', true ),
			'Google'    => array( 'google', true ),
			'Twitter'   => array( 'twitter', true ),
			'Linkedin'  => array( 'linkedin', true ),
			'Pinterest' => array( 'pinterest', true ),
			'Tumblr'    => array( 'tumblr', true ),
			'Buffer'    => array( 'buffer', true ),
			'Total'     => array( 'total', true ),
			'Date'      => array( 'post_date', true ),
		);

		return $sortable_columns;
	}

	/**
	 * Get an associative array ( id => link ) with the list
	 * of views available on this table.
	 *
	 * @since 3.32
	 * @param null
	 * @return Array
	 */
	public function get_views() {
		return apply_filters( WPUSB_Utils::add_prefix( $this->tag . 'views' ), array() );
	}

	/**
	 * Display a monthly dropdown for filtering items
	 *
	 * @since 3.32
	 * @param String $post_type
	 * @global wpdb      $wpdb
	 * @global WP_Locale $wp_locale
	 * @return Void
	 */
	public function months_dropdown( $post_type = '' ) {
		global $wpdb, $wp_locale;

		$results = $wpdb->get_results(
			"SELECT DISTINCT
				YEAR( `post_date` ) AS year,
				MONTH( `post_date` ) AS month
			 FROM
				`{$this->table}`
			 ORDER BY
				`post_date` DESC
			"
		);

		$results = apply_filters(
			WPUSB_Utils::add_prefix( $this->tag . 'months_dropdown_results' ),
			$results
		);

		if ( ! isset( $results[2] ) ) {
			return;
		}

		$m       = WPUSB_Utils::get( 'm', 0, 'intval' );
		$options = '';

		foreach ( $results as $result ) :
			if ( 0 === (int)$result->year ) {
				continue;
			}

			$month = zeroise( $result->month, 2 );
			$year  = $result->year;

			$options .= sprintf(
				'<option value="%s" %s>%s</option>',
				intval( $result->year . $month ),
				WPUSB_Utils::selected( $m, $year . $month ),
				sprintf( __( '%1$s %2$d' ), $wp_locale->get_month( $month ), $year )
			);
		endforeach;

		WPUSB_Sharing_Report_View::render_months_dropdown( $options, $m );
	}

	/**
	 * Extra controls to be displayed between bulk actions and pagination
	 *
	 * @since 3.32
	 * @param string $which
	 * @return Void
	 */
	public function extra_tablenav( $which ) {
	?>
		<div class="alignleft actions">
	<?php
		if ( 'top' === $which && ! is_singular() ) :
			ob_start();

			$this->months_dropdown();

			do_action( WPUSB_Utils::add_prefix( $this->tag . 'restrict_manage_posts' ), $which );

			$output = ob_get_clean();
			ob_end_flush();

			if ( ! empty( $output ) ) :
				echo $output;

				submit_button( __( 'Filter' ), '', '', false);
			endif;
		endif;
	?>
		</div>
	<?php
		do_action( WPUSB_Utils::add_prefix( $this->tag . 'extra_tablenav' ), $which );
	}

	/**
	 * Generate the table navigation above or below the table
	 *
	 * @since 3.32
	 * @param string $which
	 * @return Void
	 */
	public function display_tablenav( $which ) {
	?>
		<div class="tablenav <?php echo esc_attr( $which ); ?>">

			<?php if ( $this->has_items() && ! empty( $this->actions ) ): ?>

			<div class="alignleft actions bulkactions">
				<?php $this->bulk_actions( $which ); ?>
			</div>

			<?php
			endif;

			$this->extra_tablenav( $which );
			$this->pagination( $which );
	?>
			<br class="clear" />
		</div>
	<?php
	}

	/**
	 * Prepare item for record add in wp list table
	 *
	 * @since 1.1
	 * @param Null
	 * @return Array
	 */
	public function prepare_items() {
		$orderby               = $this->_get_sql_orderby( WPUSB_Utils::get( 'orderby' ), 'total' );
		$order_type            = $this->_get_sql_order( WPUSB_Utils::get( 'order' ), 'desc' );
		$current_page          = $this->get_pagenum();
		$total_items           = self::_total_items();
		$this->_column_headers = $this->get_column_info();
		$per_page              = $this->get_items_per_page(
			WPUSB_Utils::add_prefix( '_posts_per_page' ),
			self::POSTS_PER_PAGE
		);

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'total_pages' => ceil( $total_items / $per_page ),
			'per_page'    => $per_page,
		) );

		$this->items = self::_get_sharing_report( $per_page, $current_page, $orderby, $order_type );
	}

	/**
	 * Return message in wp list table case empty records
	 *
	 * @since 1.0
	 * @param Null
	 * @return String
	 */
	public function no_items() {
		_e( 'There is no record available at the moment!', WPUSB_App::TEXTDOMAIN );
	}

	/**
	 * Set report page view
	 *
	 * @since 1.3
	 * @param null
	 * @return Void
	 */
	public function report() {
		WPUSB_Sharing_Report_View::render_sharing_report( $this );
	}

	/**
	 * Verify sql orderby param
	 *
	 * @since 1.2
	 * @param String $orderby
	 * @param String $default
	 * @return String
	 */
	private function _get_sql_orderby( $orderby, $default = '' ) {
		$permissions = array(
			'post_title' => '',
			'post_date'  => '',
			'facebook'   => '',
			'twitter'    => '',
			'google'     => '',
			'linkedin'   => '',
			'pinterest'  => '',
			'tumblr'     => '',
			'buffer'     => '',
			'total'      => '',
		);

		return isset( $permissions[ $orderby ] ) ? $orderby : $default;
	}

	/**
	 * Verify sql order param
	 *
	 * @since 1.0
	 * @param String $order
	 * @param String $default
	 * @return String
	 */
	private function _get_sql_order( $order, $default = '' ) {
		$permissions = array( 'desc' => '', 'asc'  => '' );
		$order       = isset( $permissions[ $order ] ) ? $order : $default;

		return strtoupper( $order );
	}
}