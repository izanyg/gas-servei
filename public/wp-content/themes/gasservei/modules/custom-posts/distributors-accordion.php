<?php

$dist = new WP_Query(array(
    "post_type" => "distribuidores",
    "posts_per_page" => -1,
));

$sedes = array();
$internacional = array();
$nacional = array();
$comunidades = array();
while ($dist->have_posts()) : $dist->the_post();
  while (have_rows('adreces')) : the_row();
    $content = '<div class="distributor-body"><h5>' . get_the_title() . '</h5><p>' . str_replace(array("\r", "\n"), "", get_sub_field("adreca_completa")) . '</p></div>';
    $type= get_sub_field("tipo");
    if (isset($type) && $type == 'Sede')
    {
      array_push($sedes, $content);
    }else if( get_sub_field("internacional") ){
      if (!isset($internacional[get_sub_field("internacional")])) {
        $internacional[get_sub_field("internacional")] = array();
      }
      array_push($internacional[get_sub_field("internacional")], $content);
    }else{
      if (!isset($nacional[get_sub_field("comunitat")][get_sub_field("provincia")])) {
        $nacional[get_sub_field("comunitat")][get_sub_field("provincia")] = array();
      }
      if (!in_array (get_sub_field("comunitat"), $comunidades)) {
        array_push($comunidades, get_sub_field("comunitat"));
      }
      array_push($nacional[get_sub_field("comunitat")][get_sub_field("provincia")], $content);
    }
  endwhile;
endwhile;



function print_group($distributors, $ubication = false, $heading = 'h3'){
  if ($ubication && strlen($ubication) > 3) {
    echo '<'.$heading.'>' . $ubication . '</'.$heading.'>';
  }
  if (is_array($distributors)) {
    foreach ($distributors as $ubicacion => $distributor) {
        if ($ubicacion && $ubicacion =! 'sedes' && strlen($ubicacion) > 3) {
          echo '<h4>' . $ubicacion . '</h4>';
        }
        if (is_array($distributor)) {
          foreach ($distributor as $loc => $distri)
          {
            var_dump($distributor);
            print_group($distri, $loc);
          }
        } else {
            echo $distributor;
        }
    }
  }else{
    echo $distributors;
  }
}


ksort($sedes);
ksort($internacional);
ksort($nacional);



?>



<div id="distributors-tabs">
  <div class="dt-header">
    <div class="dt-button active" data-type="nacional">
      <?php echo __('Nacional'); ?>
    </div>
    <div class="dt-button" data-type="internacional">
      <?php echo __('Internacional'); ?>
    </div>
    <div class="dt-button" data-type="sedes">
      <?php echo __('Sedes'); ?>
    </div>
  </div>
  <div class="dt-body">
    <div class="dt-content active" data-type="nacional">
      <?php
        asort($comunidades);
        foreach ($comunidades as $comunidad){
          echo '<div class="accordion">';
            echo '<h3>' . $comunidad . '<span class="toggler"></span></h3></h3>';
            echo '<div class="accordion-content">';
              ksort($nacional[$comunidad]);
              foreach ($nacional[$comunidad] as $provincia => $array)
              {
                print_group($array, $provincia, 'h4');
              }
            echo '</div>';
          echo '</div>';
        }
      ?>
    </div>
    <div class="dt-content" data-type="internacional">
      <?php
        foreach ($internacional as $pais => $array)
        {
          echo '<div class="accordion">';
            echo '<h3>' . $pais . '<span class="toggler"></span></h3>';
            echo '<div class="accordion-content">';
              print_group($array);
            echo '</div>';
          echo '</div>';
          
        }
      ?>
    </div>
    <div class="dt-content" data-type="sedes">
      <?php
          foreach ($sedes as $sede)
          {
            echo $sede;
          }
      ?>
    </div>
  </div>
</div>