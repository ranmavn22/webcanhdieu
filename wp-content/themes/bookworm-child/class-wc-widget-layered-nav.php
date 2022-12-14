<?php
/**
 * Layered nav widget
 *
 * @package WooCommerce\Widgets
 * @version 2.6.0
 */

use Automattic\WooCommerce\Internal\ProductAttributesLookup\Filterer;

defined( 'ABSPATH' ) || exit;

/**
 * Widget layered nav class.
 */
class WC_Widget_Layered_Nav_N extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_layered_nav woocommerce-widget-layered-nav';
		$this->widget_description = __( 'Display a list of attributes to filter products in your store.', 'woocommerce' );
		$this->widget_id          = 'woocommerce_layered_nav_t';
		$this->widget_name        = __( 'Filter Products by Attribute 2', 'woocommerce' );
		parent::__construct();
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * @see WP_Widget->update
	 *
	 * @param array $new_instance New Instance.
	 * @param array $old_instance Old Instance.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$this->init_settings();
		return parent::update( $new_instance, $old_instance );
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @see WP_Widget->form
	 *
	 * @param array $instance Instance.
	 */
	public function form( $instance ) {
		$this->init_settings();
		parent::form( $instance );
	}

	/**
	 * Init settings after post types are registered.
	 */
	public function init_settings() {
		$attribute_array      = array();
		$std_attribute        = '';
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( ! empty( $attribute_taxonomies ) ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					$attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
				}
			}
			$std_attribute = current( $attribute_array );
		}

		$this->settings = array(
			'title'        => array(
				'type'  => 'text',
				'std'   => __( 'Filter by', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'attribute'    => array(
				'type'    => 'select',
				'std'     => $std_attribute,
				'label'   => __( 'Attribute', 'woocommerce' ),
				'options' => $attribute_array,
			),
			'display_type' => array(
				'type'    => 'select',
				'std'     => 'list',
				'label'   => __( 'Display type', 'woocommerce' ),
				'options' => array(
					'list'     => __( 'List', 'woocommerce' ),
					'dropdown' => __( 'Dropdown', 'woocommerce' ),
				),
			),
			'query_type'   => array(
				'type'    => 'select',
				'std'     => 'and',
				'label'   => __( 'Query type', 'woocommerce' ),
				'options' => array(
					'and' => __( 'AND', 'woocommerce' ),
					'or'  => __( 'OR', 'woocommerce' ),
				),
			),
		);
	}

	/**
	 * Get this widgets taxonomy.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_taxonomy( $instance ) {
		if ( isset( $instance['attribute'] ) ) {
			return wc_attribute_taxonomy_name( $instance['attribute'] );
		}

		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( ! empty( $attribute_taxonomies ) ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					return wc_attribute_taxonomy_name( $tax->attribute_name );
				}
			}
		}

		return '';
	}

	/**
	 * Get this widgets query type.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_query_type( $instance ) {
		return isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
	}

	/**
	 * Get this widgets display type.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_display_type( $instance ) {
		return isset( $instance['display_type'] ) ? $instance['display_type'] : 'list';
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args Arguments.
	 * @param array $instance Instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! is_shop() && ! is_product_taxonomy() )
			return;

		$taxonomy           = $this->get_instance_taxonomy( $instance );
		$query_type         = $this->get_instance_query_type( $instance );

		if ( ! taxonomy_exists( $taxonomy ) ) {
			return;
		}

		$terms = get_terms( $taxonomy, array( 'hide_empty' => '1' ) );

		if ( 0 === count( $terms ) ) {
			return;
		}

		ob_start();

		$this->widget_start( $args, $instance );

        $this->layered_nav_list( $terms, $taxonomy, $query_type );

		$this->widget_end( $args );

        echo ob_get_clean();
	}

	/**
	 * Return the currently viewed taxonomy name.
	 *
	 * @return string
	 */
	protected function get_current_taxonomy() {
		return is_tax() ? get_queried_object()->taxonomy : '';
	}

	/**
	 * Return the currently viewed term ID.
	 *
	 * @return int
	 */
	protected function get_current_term_id() {
		return absint( is_tax() ? get_queried_object()->term_id : 0 );
	}

	/**
	 * Return the currently viewed term slug.
	 *
	 * @return int
	 */
	protected function get_current_term_slug() {
		return absint( is_tax() ? get_queried_object()->slug : 0 );
	}

	/**
	 * Count products within certain terms, taking the main WP query into consideration.
	 *
	 * This query allows counts to be generated based on the viewed products, not all products.
	 *
	 * @param  array  $term_ids Term IDs.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return array
	 */
	protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
		return wc_get_container()->get( Filterer::class )->get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type );
	}

	/**
	 * Show list based layered nav.
	 *
	 * @param  array  $terms Terms.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return bool   Will nav display?
	 */
	protected function layered_nav_list( $terms, $taxonomy, $query_type ) {
		// List display.
		echo '<ul class="woocommerce-widget-layered-nav-list">';

		$term_counts        = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$found              = false;
		$base_link          = $this->get_current_page_url();

		foreach ( $terms as $term ) {
			$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
			$option_is_set  = in_array( $term->slug, $current_values, true );
			$count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

			// Skip the term for the current archive.
			if ( $this->get_current_term_id() === $term->term_id ) {
				continue;
			}

			// Only show options with count > 0.
			if ( 0 < $count ) {
				$found = true;
			}

			$filter_name = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array();
			$current_filter = array_map( 'sanitize_title', $current_filter );

			if ( ! in_array( $term->slug, $current_filter, true ) ) {
				$current_filter[] = $term->slug;
			}

			$link = remove_query_arg( $filter_name, $base_link );

			// Add current filters to URL.
			foreach ( $current_filter as $key => $value ) {
				// Exclude query arg for current term archive term.
				if ( $value === $this->get_current_term_slug() ) {
					unset( $current_filter[ $key ] );
				}

				// Exclude self so filter can be unset on click.
				if ( $option_is_set && $value === $term->slug ) {
					unset( $current_filter[ $key ] );
				}
			}

            $link = add_query_arg( $filter_name, $term->slug, $link );
            $term_html = '<a rel="nofollow" href="' . esc_url( $link ) . '">' . esc_html( $term->name ) . '</a>';


			$term_html .= ' ' . apply_filters( 'woocommerce_layered_nav_count', '<span class="count">(' . absint( $count ) . ')</span>', $count, $term );

			echo '<li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ' . ( $option_is_set ? 'woocommerce-widget-layered-nav-list__item--chosen chosen' : '' ) . '">';
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.EscapeOutput.OutputNotEscaped
			echo apply_filters( 'woocommerce_layered_nav_term_html', $term_html, $term, $link, $count );
			echo '</li>';
		}

		echo '</ul>';

		return $found;
	}
}
