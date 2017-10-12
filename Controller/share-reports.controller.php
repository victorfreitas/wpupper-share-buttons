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
	exit( 0 );
}

//View
WPUSB_App::uses( 'share-report', 'View' );
WPUSB_App::uses( 'share-report', 'Model' );
WPUSB_App::uses( 'list-table', 'Vendor' );

if ( ! class_exists( 'WP_Screen' ) ) {
	WPUSB_Utils::include_file_screen();
}

if ( ! class_exists( 'Walker_Category_Checklist' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/template.php' );
}

class WPUSB_Share_Reports_Controller extends WPUSB_List_Table {

	/**
	 * Number for posts per page
	 *
	 * @since 1.1
	 * @var Integer
	 */
	const POSTS_PER_PAGE = 15;

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
	public $tag = 'sr_';

	/**
	 * Start Date
	 *
	 * @since 3.32
	 * @var string
	 */
	private $start_date;

	/**
	 * End Date
	 *
	 * @since 3.32
	 * @var string
	 */
	private $end_date;

	public function __construct() {
		$this->_set_property();

		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_init', array( $this, 'export_csv' ) );

		parent::__construct(
			array(
				'singular' => 'social-share-report',
				'plural'   => 'social-sharing-reports',
				'screen'   => WPUSB_Utils::add_prefix( '_sharing_report' ),
				'ajax'     => false,
			)
		);
	}

	/**
	 * Set property query string param
	 *
	 * @since 3.32
	 * @param Null
	 * @return Void
	 */
	private function _set_property() {
		$this->table      = WPUSB_Utils::get_table_name();
		$this->search     = WPUSB_Utils::get( 's', '', 'esc_sql' );
		$this->start_date = WPUSB_Utils::get( 'start_date' );
		$this->end_date   = WPUSB_Utils::get( 'end_date' );
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
			  __( 'Sharing Report | WPUpper Share Buttons', 'wpupper-share-buttons' ),
			  __( 'Sharing Report', 'wpupper-share-buttons' ),
			  WPUSB_Utils::get_capability(),
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
	 * @param $output String
	 * @return Object
	 */
	private function _get_sharing_report( $posts_per_page, $current_page, $orderby, $order, $output = OBJECT ) {
		global $wpdb;

		if ( ! $this->_table_exists( $wpdb ) ) {
			return;
		}

		$offset = ( ( $current_page - 1 ) * self::POSTS_PER_PAGE );
		$where  = $this->_where();
		$limit  = ( $output === OBJECT ) ? 'LIMIT %d OFFSET %d' : '';
		$query  = "SELECT * FROM `{$this->table}` {$where} ORDER BY `{$orderby}` {$order} {$limit}";

		if ( ! empty( $limit ) ) {
			$query = $wpdb->prepare( $query, array( $posts_per_page, $offset ) );
		}

		return $wpdb->get_results( $query, $output );
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

		if ( ! $this->_table_exists( $wpdb ) ) {
			return 0;
		}

		$where = $this->_where();

		return (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$this->table} {$where}" );
	}

	/**
	 * Create sql where post title for search
	 *
	 * @since 1.0
	 * @since 3.32
	 * @param Null
	 * @return String
	 */
	private function _where() {
		global $wpdb;

		$search = $wpdb->esc_like( $this->search );
		$where  = '';

		if ( ! empty( $search ) ) {
			$where .= " `post_title` LIKE '%%{$search}%%'";
		}

		$where = $this->_get_date_range_where( $where );
		$where = ( $where ) ? 'WHERE' . $where : '';

		return apply_filters( WPUSB_Utils::add_prefix( $this->tag . 'where' ), $where );
	}

	/**
	 * Add date range filter for query
	 *
	 * @since 3.32
	 * @param String $where
	 * @return String
	 */
	private function _get_date_range_where( $where ) {
		$and        = ( $where ) ? ' AND' : '';
		$start_date = WPUSB_Utils::convert_date_for_sql( $this->start_date, 'Y-m-d' );
		$end_date   = WPUSB_Utils::convert_date_for_sql( $this->end_date, 'Y-m-d' );

		if ( ! $start_date && ! $end_date ) {
			return $where;
		}

		if ( $start_date && $end_date ) {
			$where .= sprintf( "%s `post_date` BETWEEN '%s' AND '%s'", $and, $start_date, $end_date );
			return $where;
		}

		if ( $start_date ) {
			$where .= sprintf( "%s `post_date` >= '%s'", $and, $start_date );
			return $where;
		}

		if ( $end_date ) {
			$where .= sprintf( "%s `post_date` <= '%s'", $and, $end_date );
			return $where;
		}
	}

	/**
	 * Verify table exists in database
	 *
	 * @since 1.0
	 * @param Object $wpdb
	 * @return String
	 */
	private function _table_exists( $wpdb ) {
		return $wpdb->query( "SHOW TABLES LIKE '{$this->table}'" );
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
		$value  = '';

		switch ( $column ) :
			case 'title':
				$value = WPUSB_Sharing_Report_View::get_permalink_title( $item );
				break;

			case 'facebook':
			case 'twitter':
			case 'google':
			case 'linkedin':
			case 'pinterest':
			case 'tumblr':
			case 'buffer':
			case 'total':
				$value = $this->format_number( $item->{$column} );
				break;

			case 'date':
				$value = $this->get_date_i18n( $item->post_date );
				break;

			default:
				$value = '';
		endswitch;

		return apply_filters( WPUSB_Utils::add_prefix( $this->tag . 'column' ), $value, $item, $column );
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
			'Title'     => __( 'Title', 'wpupper-share-buttons' ),
			'Facebook'  => __( 'Facebook', 'wpupper-share-buttons' ),
			'Twitter'   => __( 'Twitter', 'wpupper-share-buttons' ),
			'Google'    => __( 'Google+', 'wpupper-share-buttons' ),
			'Linkedin'  => __( 'Linkedin', 'wpupper-share-buttons' ),
			'Pinterest' => __( 'Pinterest', 'wpupper-share-buttons' ),
			'Tumblr'    => __( 'Tumblr', 'wpupper-share-buttons' ),
			'Buffer'    => __( 'Buffer', 'wpupper-share-buttons' ),
			'Total'     => __( 'Total', 'wpupper-share-buttons' ),
			'Date'      => __( 'Post date', 'wpupper-share-buttons' ),
		);

		return apply_filters( WPUSB_Utils::add_prefix( $this->tag . 'columns' ), $columns );
	}

	/**
	 * Set orderby in column wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	public function get_sortable_columns() {
		$sort_columns = array(
			'Title'     => array( 'post_title', true ),
			'Facebook'  => array( 'facebook', true ),
			'Twitter'   => array( 'twitter', true ),
			'Google'    => array( 'google', true ),
			'Linkedin'  => array( 'linkedin', true ),
			'Pinterest' => array( 'pinterest', true ),
			'Tumblr'    => array( 'tumblr', true ),
			'Buffer'    => array( 'buffer', true ),
			'Total'     => array( 'total', true ),
			'Date'      => array( 'post_date', true ),
		);

		return apply_filters( WPUSB_Utils::add_prefix( $this->tag . 'sort_columns' ), $sort_columns );
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
	 * Extra controls to be displayed between bulk actions and pagination
	 *
	 * @since 3.32
	 * @param string $which
	 * @return Void
	 */
	public function extra_tablenav( $which ) {
		if ( ( ! $this->has_items() && ! isset( $_GET['paged'] ) ) || 'top' !== $which || is_singular() ) {
			return;
		}

		echo '<div class="alignleft actions">';

		if ( $this->has_items() ) {
			WPUSB_Sharing_Report_View::export_csv_btn();
		}

			WPUSB_Sharing_Report_View::render_date_range_filter();

			submit_button( __( 'Filter' ), '', '', false );

		echo '</div>';

	}

	/**
	 * Export to CSV curent results
	 *
	 * @since 3.32
	 * @param Null
	 * @return Void
	 */
	public function export_csv() {
		if ( ! WPUSB_Utils::is_sharing_report_page() || 'true' !== WPUSB_Utils::get( 'export' ) ) {
			return;
		}

		$this->prepare_items( ARRAY_A );
		$this->csv_headers();
		$this->render_csv();
		exit( 1 );
	}

	/**
	 * The post title
	 *
	 * @since 3.32
	 * @param $integer $post_id
	 * @return String
	 */
	public function get_title( $post_id ) {
		return WPUSB_Utils::rm_tags( get_the_title( $post_id ) );
	}

	/**
	 * Render CSV output
	 *
	 * @since 3.32
	 * @param Null
	 * @return Void
	 */
	public function render_csv() {
		if ( empty( $this->items ) ) {
			return;
		}

		ob_start();

		$out = fopen( 'php://output', 'w' );

		fputcsv( $out,  $this->get_columns() );

		foreach ( $this->items as $rows ) :
			$rows['post_date'] = $this->get_date_i18n( $rows['post_date'] );
			$title             = $this->get_title( $rows['post_id'] );

			if ( ! empty( $title ) ) {
				$rows['post_title'] = $title;
			}

			unset( $rows['id'] );
			unset( $rows['post_id'] );

			$rows = array_map( array( $this, 'format_number' ), $rows );

			fputcsv( $out, $rows );
		endforeach;

		fclose( $out );

		$output = ob_get_contents();
		ob_end_clean();

		echo WPUSB_Utils::html_decode( $output );
	}

	/**
	 * Format share counts
	 *
	 * @since 3.32
	 * @param Integer $value
	 * @return String
	 */
	public function format_number( $value ) {
		if ( ! is_numeric( $value ) ) {
			return $value;
		}

		return WPUSB_Utils::format_number( $value );
	}

	/**
	 * Get the CSV name formated
	 *
	 * @since 3.32
	 * @param Null
	 * @return String
	 */
	public function get_csv_name() {
		$date = $this->get_date_i18n( date( 'Y-m-d' ), true );

		return sprintf( '%s-sharing-report-%s.csv', WPUSB_App::SLUG, $date );
	}

	/**
	 * Set CSV headers download
	 *
	 * @since 3.32
	 * @param Null
	 * @return Void
	 */
	public function csv_headers() {
		header( 'Content-Encoding: ' . WPUSB_Utils::get_charset() );
		header( 'Content-type: text/csv' );
		header( 'Content-Disposition: attachment; filename=' . $this->get_csv_name() );
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

			<?php if ( $this->has_items() && ! empty( $this->actions ) ) : ?>

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
	public function prepare_items( $output = OBJECT ) {
		$orderby               = $this->_get_sql_orderby( WPUSB_Utils::get( 'orderby' ), 'total' );
		$order_type            = $this->_get_sql_order( WPUSB_Utils::get( 'order' ), 'desc' );
		$current_page          = $this->get_pagenum();
		$total_items           = self::_total_items();
		$this->_column_headers = $this->get_column_info();
		$per_page              = $this->get_items_per_page(
			WPUSB_Utils::add_prefix( $this->tag . '_items_per_page' ),
			self::POSTS_PER_PAGE
		);

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'total_pages' => ceil( $total_items / $per_page ),
				'per_page'    => $per_page,
			)
		);

		$this->items = self::_get_sharing_report( $per_page, $current_page, $orderby, $order_type, $output );
	}

	/**
	 * Return message in wp list table case empty records
	 *
	 * @since 1.0
	 * @param Null
	 * @return String
	 */
	public function no_items() {
		_e( 'There is no record available at the moment!', 'wpupper-share-buttons' );
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
		$permissions = array(
			'desc' => '',
			'asc'  => '',
		);
		$order       = isset( $permissions[ $order ] ) ? $order : $default;

		return strtoupper( $order );
	}

	/**
	 * Translate post date
	 *
	 * @since 3.32
	 * @param String $date
	 * @return String
	 */
	public function get_date_i18n( $date, $is_file = false ) {
		$date_i18n = esc_attr( date_i18n( __( 'Y/m/d' ), strtotime( $date ) ) );

		return $is_file ? str_replace( '/', '-', $date_i18n ) : $date_i18n;
	}
}
