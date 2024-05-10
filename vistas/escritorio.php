<?php
  //Activacion de almacenamiento en buffer
  ob_start();
  //iniciamos las variables de session
  session_start();

if (isset($_SESSION["num_documento"])) {
  if (
    $_SESSION["num_documento"] === '25152713' //DNI MARIANO
    || $_SESSION["num_documento"] === '16456362' //DNI LUIX
    || $_SESSION["num_documento"] === '39672512' //DNI CHRISTIAN
    || $_SESSION["num_documento"] === '40754538' //DNI LUCIANA
  ) {
    if (!isset($_SESSION["noticias"])) {
      $_SESSION["noticias"] = '1';
    }
  }
}

  /*else  //Agrega toda la vista
  {*/
    require 'header.php';

    /*if($_SESSION['escritorio'] == 1)
    {*/
        
?>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Sección de Noticias</h1>
                          <?php
                          if(isset($_SESSION['noticias']) && $_SESSION['noticias'] == 1)
                          {
                          echo '<a href="noticias.php"><button style="margin-left: 10px;" class="btn btn-success">Editor de Noticias</button></a>' ;
                          } ?>
                            
                            <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                        <div class="swiper-container mySwiper" style="display:flex; overflow:hidden" id="blogSection">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination" style="border-radius: 15px; background:white"></div>

                        <div class="swiper-wrapper">
                      
                        <!--************** QUERY NOTICIAS **************  -->
                        <?php 
                        require "../config/conexionNews.php";
                        $sql = "SET lc_time_names = 'es_ES'"; 
                        $result = $conexion->query($sql);
                        $sql = "SELECT 
                        n.titulo, n.descripcion,
                        CONCAT(UPPER(LEFT(DATE_FORMAT(DATE(n.fecha_hora), '%W, %e de '),1)),
                        SUBSTRING(DATE_FORMAT(DATE(n.fecha_hora), '%W, %e de '),2),
                        UPPER(LEFT(DATE_FORMAT(DATE(n.fecha_hora), '%M de %Y'),1)),
                        SUBSTRING(DATE_FORMAT(DATE(n.fecha_hora), '%M de %Y'),2)) as fecha_hora,
                        n.idsector AS sector,
                        CONCAT(a.carpeta,a.fuente) AS ruta 
                        from intranetNews.noticias n 
                        INNER JOIN intranetNews.archivo a
                        ON a.idnoticia = n.idnoticia
                         where n.condicion = 1
                         ORDER BY n.fecha_hora DESC";
                        $result = $conexion->query($sql);
                        if($result->num_rows == 0){
                            echo "No hay noticias";
                        }
                        while($row = $result->fetch_assoc()){
                            
                        ?>
                        <div class="swiper-slide card border-dark mb-3" style="width: 24rem; padding:10px;  background: whitesmoke; ">
                            <h4><i><?php echo $row['fecha_hora']; ?></i></h4>
                            <img style="width:100%;height:17rem;cursor:zoom-in " onclick="window.open(<?php echo '\''.$row['ruta'].'\''; ?>)" src="<?php echo (strstr($row['ruta'],'pdf') == true)?'../uploads/PDF_file_icon.png':$row['ruta']; ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                            <h4 class="card-text"><?php echo $row['sector']; ?></h4>
                                <h4 class="card-title"><b><?php echo $row['titulo']; ?></b></h5>
                                <p class="card-text" style="font-size: 15px"><?php echo $row['descripcion']; ?></p>
                               <!-- <a href="#" class="btn btn-primary">Go somewhere</a>-->
                            </div>
                            </div>
                        <?php 
                        }
                        
                        ?>
                        
                        
                            </div>
                        </div>
                    </div>
					
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->


<?php
  
/*  } //Llave de la condicion if de la variable de session

  else
  {
    require 'noacceso.php';
  }*/

  require 'footer.php';
?>

<script src="./scripts/escritorio.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script>
var swiper = new Swiper(".mySwiper",{
    navigation:{
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        
    },
    autoplay: {
   delay: 10000,
   
 },
    slidesPerView:1,
    spaceBetween:10,
    pagination:{
        el:".swiper-pagination",
        clickable:true,
    },
    breakpoints:{
        620:{
            slidesPerView:1,
            spaceBetween:10,
        },
        680:{
            slidesPerView:2,
            spaceBetween:10,
        },
        920:{
            slidesPerView:3,
            spaceBetween:10,
        },
        1240:{
            slidesPerView:4,
            spaceBetween:10,
        }
    },
})

</script>



<?php
 // }
  ob_end_flush(); //liberar el espacio del buffer
?>