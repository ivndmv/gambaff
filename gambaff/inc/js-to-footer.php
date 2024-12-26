<?php
add_action('wp_footer', 'show_hide_content_js');
function show_hide_content_js() {
    ?>
    <script defer="defer">
        const overflowTextElements = document.querySelectorAll('.view-more-expand-content')
        if (overflowTextElements.length > 0) {
            overflowTextElements.forEach(element => {
                let clickCount = 1
                element.style.overflow = 'hidden'
                if(element.offsetHeight > 150) {
                    element.style.height = '150px'
                    let showMoreButton = document.createElement('button')
                    showMoreButton.textContent = '<?php echo __('show more', 'gambaff'); ?>'
                    showMoreButton.type = 'button'
                    showMoreButton.classList.add('view-more-button')
                    element.after(showMoreButton)
                    showMoreButton.addEventListener('click', e => {
                        clickCount++
                        if (clickCount%2 == 0) {
                            element.style.height = 'unset'
                            showMoreButton.textContent = '<?php echo __('hide', 'gambaff'); ?>'
                        }
                        else {
                            element.style.height = '150px'
                            showMoreButton.textContent = '<?php echo __('show more', 'gambaff'); ?>'
                        }
                    })
                }
            })   
        }

    </script>
<?php
}
?>