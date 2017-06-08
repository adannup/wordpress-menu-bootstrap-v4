<?php
    //
    add_action( 'init', 'custom_menu' );


    //Function to register menu
    function custom_menu() {
        register_nav_menu('mainmenu',__( 'Menu de inicio' ));
    }


    // Intented to use bootstrap 4 Alpha 6.
    // After register the menu, you may add create_bootstrap_menu('mainmenu') in header.php
    //$theme_location [parameter] -> Name of the register nav menu previous created.
      
    #add this function in your theme functions.php
    function create_bootstrap_menu($theme_location) {
        //Validate if exist the custom menu
        if (($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location])){

            //Variables para obtener los elementos desde Wordpress
            $menu           =   get_term($locations[$theme_location]);
            $menu_items     =   wp_get_nav_menu_items($menu->term_id);

            //Se forma el array con los menus y sus submenus hijos
            foreach($menu_items as $menu_item){
                //Si el elemento de menu No tiene un padre entonces se almacena como un elemento padre menu.
                if(!$menu_item->menu_item_parent){
                    $elements[$menu_item->ID] = array (
                        "title" =>  $menu_item->title,
                        "url"   =>  $menu_item->url
                    );
                }else{
                    //Si el elemento de menu tiene un padre entonces se alamacena como el elemento hijo del padre al que corresponde
                    $elements[$menu_item->menu_item_parent]["child"][]  = array (
                        "title" =>  $menu_item->title,
                        "url"   =>  $menu_item->url
                    );
                }
            }

            // <!-- Start the menu with Bootstrap 4 -->
            $nav    .=  '<nav class="navbar navbar-toggleable-md navbar-light">' ."\n";
            $nav    .=  '<button class="navbar-toggler navbar-toggler-right mt-2" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">'."\n";
            $nav    .=  '<span class="navbar-toggler-icon"></span>'."\n";
            $nav    .=  '</button>'."\n";
            $nav    .=  '<img src="./public/brand/logo-principal.png" class="img-fluid img-brand" alt="">'."\n";

            // <!-- DIV de inicio de contenedor de elementos de menu
            $nav    .=  '<div class="collapse navbar-collapse" id="navbarNavDropdown">'."\n";
            $nav    .=  '<ul class="navbar-nav ml-auto">'."\n";

            //Se forma el nav con los elementos
            foreach ($elements as $element) {
                if($element["child"]){
                    //Si el elemento de menu tiene hijos entonces se crea el elemento con las clases de bootstrap, usando Dropdown para que se pueda mostrar los elementos hijos
                    $nav    .=  '<li class="nav-item dropdown nav-item-border">'."\n";
                    $nav    .=   '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$element['title'].'</a>'."\n";

                    $nav    .=  '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">'."\n";
                    //Se recorre el array para obtener los elementos hijos del padre, y se crea el elemento para ser renderizado en el DOM.
                    foreach ($element["child"] as $child) {
                        $nav    .=  '<a class="dropdown-item" href="#">'.$child['title'].'</a>'."\n";
                    }
                    $nav    .=  '</div>'."\n";
                    $nav    .=  '</li>'."\n";
                    //<!-- </li> -->
                }else{
                    //Si el elemento menu NO tiene hijos entonces se genera un unico menu usando las respectivas etiquetas de Bootstrap
                    $nav    .=  '<li class="nav-item nav-item-border">'."\n";
                    $nav    .=  '<a class="nav-link" href="#">'.$element['title'].'</a>'."\n";
                    $nav    .=  '</li>'."\n";
                }
            }
            $nav    .=  '</ul>'."\n";
            $nav    .=  '</div>'."\n";
            $nav    .=  '</nav>'."\n";
            // <!-- Finish the menu with Bootstrap 4 -->
        }else{
            //If doesn't exist a previous menu register, show the next message
            echo "<h3>Menu don't found!</h3>";
        }

        echo $nav;
    }