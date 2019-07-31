

<?php 
$path = $_REQUEST['dir'];
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title>SD Team Staging Server</title>
        <meta name="description" content="The HTML5 Herald" />
        <meta name="conceptnova" content="Concept nova taging server" />
        <link rel="stylesheet" href="css/styles.css?v=1.0" />
        <link rel="stylesheet" href="filemanager.css" type="text/css" />
        <script
            type="text/javascript"
            src="http://code.jquery.com/jquery-1.11.1.min.js"
        ></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#container').html(
                    '<ul class="filetree start"><li class="wait">' +
                        'Generating Tree...' +
                        '<li></ul>'
                )

                $('#selected_file').text(
                            'File:  ' + $(this).attr('rel')
                        )


                getfilelist($('#container'), '<?php echo $path; ?>')

                function getfilelist(cont, root) {
                    $(cont).addClass('wait')

                    $.post('listall.php', { dir: root }, function(data) {
                        $(cont)
                            .find('.start')
                            .html('')
                        $(cont)
                            .removeClass('wait')
                            .append(data)
                        if ('<?php echo $path; ?>' == root)
                            $(cont)
                                .find('UL:hidden')
                                .show()
                        else
                            $(cont)
                                .find('UL:hidden')
                                .slideDown({ duration: 500, easing: null })
                    })
                }

                $('#container').on('click', 'LI A', function() {
                    var entry = $(this).parent()

                    if (entry.hasClass('folder')) {
                        if (entry.hasClass('collapsed')) {
                            entry.find('UL').remove()
                            getfilelist(entry, escape($(this).attr('rel')))
                            entry.removeClass('collapsed').addClass('expanded')
                        } else {
                            entry
                                .find('UL')
                                .slideUp({ duration: 500, easing: null })
                            entry.removeClass('expanded').addClass('collapsed')
                        }
                    } else {
                        $('#selected_file').text(
                            'File:  ' + $(this).attr('rel')
                        )
                    }
                    return false
                })
            })
        </script>
    </head>

    <body>
        <div id="logo">
            <h1>
                <a href="/"
                    ><img
                        src="https://erp.concept-nova.com/assets/img/logo.png"
                        alt="Staging server file manager"
                        border="0"
                        style="border: 0px;"
                /></a>
            </h1>
            <div id="pgtitle">
                SD Team Staging Server
            </div>
            <div><a href="/phpmyadmin">PHPMyAdmin</a></div>
            <!-- <div><a href="/phpmyadmin">Switch to File View</a></div> -->
        </div>
        <div id="container"></div>
        <!-- <div id="selected_file"></div> -->
    </body>
</html>
