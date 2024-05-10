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
   // require 'header.php';

    /*if($_SESSION['escritorio'] == 1)
    {*/
        
?>
<link rel="stylesheet" href="../public/css/_all-skins.min.css">
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
                          <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                        <div class="swiper-container mySwiper" style="display:flex; overflow:hidden" id="blogSection">

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
                        s.nombre AS sector,
                        CONCAT(a.carpeta,a.fuente) AS ruta 
                        from intranetNews.noticias n 
                        INNER JOIN intranetNews.archivo a
                        ON a.idnoticia = n.idnoticia
                        INNER JOIN dbprocs.sector s
                        ON s.idsector = n.idsector
                         where n.condicion = 1
                         ORDER BY n.fecha_hora DESC";
                        $result = $conexion->query($sql);
                        if($result->num_rows == 0){
                            echo "No hay noticias";
                        }
                        while($row = $result->fetch_assoc()){
                            
                        ?>
                        <div class="swiper-slide" >
                          
                            <h4 class="date-title"><i><?php echo $row['fecha_hora']; ?> | <?php echo $row['sector']; ?></i></h4>
                            <img class="foto-titular"  src="<?php echo $row['ruta']; ?>" class="card-img-top" alt="...">
                            <div class="card-body" style="margin: -10px">
                            <h4 class="card-text"></h4>
                                <h4 class="card-title"><b><?php echo $row['titulo']; ?></b></h5>
                                <p class="card-text descripcion" ><?php echo $row['descripcion']; ?></p>
                                
                               <!-- <a href="#" class="btn btn-primary">Go somewhere</a>-->
                            </div>
                            </div>

                            
                            
                           
                        <?php 
                        }
                        
                        ?>
                        
                        
                            </div>
                            <div class="swiper-counter"><span class="current">1</span> / <span class="total">0</span></div>
<div class="swiper-progress-bar">
	<div class="progress"></div>
	<div class="progress-sections"></div>
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

<style>

body {
        position: relative;
        height: 100vh;
        overflow:hidden;
        font-family: 'Source Sans Pro', sans-serif;
        background: linear-gradient(to top , black,darkred,darkred,indianred);
      }
  .swiper {
        width: 100%;
        height: 80vh;
      }

      .swiper-slide {
        text-align: center;
        font-size: 1.05em;
        background: #fff;
        padding:0;  
        background: linear-gradient(to top , black,darkred,darkred,indianred);
        height: 100vh;
        margin:0;

        
      }
      .foto-titular{
        width:60%;height:64%;
        
      }

      .date-title,.card-text {
        font-weight: 500;
        font-size: 1.8em;
        padding:0;
        color:white;
        margin:.5rem;
      }
      .card-title{
        font-size: 2.5em;
        padding:0;
        margin:0;
        color:white;
        margin-top:1.2rem;
        font-weight: 900;
      }
      .descripcion{
        font-size: 1.4em; font-weight: 500; 
        padding-left: 5rem;
        padding-right: 5rem;
        color:white;
        letter-spacing: 1px;
      }
      .swiper-progress-bar{
	width: 90%;
    height: 4px;
	position: absolute;
	margin: 20px auto;
	background: #fff;
  margin-top: 56%;}
	.progress{
		height: inherit;
		left: 0;
		top: 0;
		position: absolute;
		background: #fff;
    opacity:0.8;
		z-index: 1;
	}
	.progress-sections{
		left: 0;
		top: 0;
		position: absolute;
		height: inherit;
		width: inherit;
		z-index: 2;
		display: flex;
		flex-direction: row;}
		span{
			flex: 1;
			height: inherit;
			border-right: 1px solid grey ;
				}
	
.swiper-counter{
	width: 600px;
	margin: 0 auto;
  position: absolute;
 
}


      
</style>
<?php
  
/*  } //Llave de la condicion if de la variable de session

  else
  {
    require 'noacceso.php';
  }*/

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="./scripts/escritorio.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script>
jQuery(document).ready(function($){
	
	let autoPlayDelay = 9000;
	
	let options = {
		init: true,
		// Optional parameters
		loop: false,
    effect:"fade",
	
		autoplay: {
			delay: autoPlayDelay,
      disableOnInteraction:false,
		},

		// If we need pagination
		/*pagination: {
			el: '.swiper-pagination',
			type: 'progressbar'
		},*/

    	// Navigation arrows
    	navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
    	},
  	};
	
	let mySwiper = new Swiper ('.swiper-container', options);
	
	let slidersCount = mySwiper.params.loop ? mySwiper.slides.length - 2 : mySwiper.slides.length;
	let widthParts = 100 / slidersCount;
	
	$('.swiper-counter .total').html(slidersCount);
	for(let i=0; i<slidersCount; i++){
		$('.swiper-progress-bar .progress-sections').append('<span></span>');
	}
	
	function initProgressBar(){
		let calcProgress = (slidersCount-1) * ((autoPlayDelay) + mySwiper.params.speed);
        calcProgress += autoPlayDelay;
		$('.swiper-progress-bar .progress').animate({
			width: '100%'
		}, calcProgress, 'linear');
	}
	
	initProgressBar();
	
	mySwiper.on('slideChange', function () {
		let progress = $('.swiper-progress-bar .progress');
		
		$('.swiper-counter .current').html(this.activeIndex + 1);
		
		if( 
			( 
				this.progress == -0 || (this.progress == 1 && this.params.loop) 
			) && !progress.parent().is('.stopped')
		){
			progress.css('width', '0');
			if(this.activeIndex == 0){
            	initProgressBar();
            }
		}
		
		if(progress.parent().is('.stopped')){		   
			progress.animate({
				'width': Math.round(widthParts * (this.activeIndex + 1)) + '%'
			}, this.params.speed, 'linear');
		}
	});
	
	mySwiper.on('touchMove', function () {
		$('.swiper-progress-bar .progress').stop().parent().addClass('stopped');
	});
	
	
});

</script>



<?php
 // }
  ob_end_flush(); //liberar el espacio del buffer
?>