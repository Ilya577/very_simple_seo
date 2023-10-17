<?php


spl_autoload_register(function ( $class ) {
  
    $file = null;
    if ( strpos( $class, 'Base_VSimple' ) !== false ) {
      $file = VSIMPLE_DIRNAME . 'classes/' . str_replace( 'base_vsimple_', '', strtolower( $class ) )  . '.php';
    }
    elseif ( strpos( $class, 'Admin_VSimple' ) !== false ) {
      $file = VSIMPLE_DIRNAME . 'admin/' . str_replace( 'admin_vsimple_', '', strtolower( $class ) )  . '.php';
    }

    if ( $file ) {
      if ( !file_exists( $file ) ) {
        return;
      }
     require( $file );
   }

  });