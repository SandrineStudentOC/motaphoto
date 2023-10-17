        <footer class="footer">
            <nav class="footer__navigation">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container' => 'ul', // afin d'éviter d'avoir une div autour 
                    'menu_class' => 'footer__navigation__menu', // ma classe personnalisée 
                    ])
                ?>
            </nav>
        </footer>
        <?php wp_footer() ?>
   </body>
</html>