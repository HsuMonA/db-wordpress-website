<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title>
            <?php wp_title('|', true, 'right'); ?>
        </title>
        <link rel="stylesheet" href="<?php echo esc_url(get_stylesheet_uri()); ?>" type="text/css" />
        <link rel="stylesheet" href="wp-content/themes/db/node_modules/@db-ui/core/dist/css/enterprise/db-ui-core.css"
            type="text/css">
        <?php wp_head(); ?>
    </head>

    <body>
        <main class="rea-main ">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="elm-logo">
                    <use href="wp-content/themes/db/node_modules/@db-ui/core/dist/images/db_logo.svg#logo"></use>
                </svg>
                <!-- [html-validate-disable-next heading-level, no-unused-disable -- we're doing some simple demonstration simplification here] -->
                <h1 class="elm-headline " data-pulse>
                    <?php bloginfo('name'); ?>
                </h1>
                <p>
                    <?php bloginfo('description'); ?>
                </p>
            </div>
            
            <?php if (have_posts()):
                while (have_posts()):
                    the_post(); ?>
                    <h3 class="elm-headline">
                        <?php the_title(); ?>
                    </h3>
                    <section aria-live="polite" data-variant="hovering">
                        <div class="cmp-notification" role="status">
                            <p>
                                <?php the_content(); ?>
                            </p>
                            <?php wp_link_pages(); ?>
                            <?php edit_post_link(); ?>
                        </div>
                    </section>
                <?php endwhile; ?>

                <?php
                if (get_next_posts_link()) {
                    next_posts_link();
                }
                ?>
                <?php
                if (get_previous_posts_link()) {
                    previous_posts_link();
                }
                ?>

            <?php else: ?>
                <p>No posts found. :(</p>
            <?php endif; ?>
            
            <?php
                global $wpdb;
                $result = $wpdb->get_results("SELECT * FROM kennzahlen WHERE kennzahl_id = '1'"); // fetch data from database from php wordpress
            ?>
            <div>
                <canvas id="myChart"></canvas>
            </div>

            <script src="wp-content/themes/db/node_modules/chart.js/dist/chart.umd.js"></script>
            <script>
            const jsObject = JSON.parse(`<?= json_encode($result) ?>`) // convert php arrays to js
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                labels: jsObject.map(row => row.datum),
                datasets: [{
                        label: 'wert_plan',
                        data: jsObject.map(row => row.wert_plan),
                        borderWidth: 1
                    },
                    {
                        label: 'wert_ist',
                        data: jsObject.map(row => row.wert_ist),
                        borderWidth: 1
                    }]
                },
                options: {
                scales: {
                    y: {
                        beginAtZero: true
                        }
                    }
                }
            });
            </script>
            <?php wp_footer(); ?>
        <main class="rea-main ">
    </body>
</html>