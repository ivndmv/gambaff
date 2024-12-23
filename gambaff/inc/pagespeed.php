<?php
//pagespeed
//js defer preload
add_filter( 'script_loader_tag', 'prefix_defer_js_rel_preload', 10, 4 );
function prefix_defer_js_rel_preload($html) {
  if ( ! is_admin() ) {
    if (!str_contains($html, '/wp-includes/js/jquery/')) {
      $html = str_replace( '></script>', ' defer></script>', $html );
    }
  }
  return $html;
}

// css defer preload
add_filter( 'style_loader_tag', 'prefix_defer_css_rel_preload', 10, 4 );
function prefix_defer_css_rel_preload( $html, $handle, $href, $media ) {
    if ( ! is_admin() ) {
        $html = '<link rel="preload" href="' . $href . '" as="style" id="' . $handle . '" media="' . $media . '" onload="this.onload=null;this.rel=\'stylesheet\'">'
            . '<noscript>' . $html . '</noscript>';
    }
    return $html;
}

//lazy load
add_action('wp_footer', 'lazy_load');
function lazy_load() {
  ?><script>
    document.querySelectorAll('.lazy-load img').forEach( img => {
        img.setAttribute('loading', 'lazy')
    })
  </script>
<?php }
?>