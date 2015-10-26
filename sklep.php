<?php
session_start();

require_once 'C:/xampp/htdocs/Sklep/model/DB.php';
$modelDB = new DBT();

$products = $modelDB->getProducts();
$productsNoRepeat=$modelDB->getProductsNoRepeat();
?>

<?php require_once 'C:/xampp/htdocs/Sklep/head.php';?>  

<script type="text/javascript">
var count;

function PassVarToPhpByAjax(ProductId,count) { 

    $.post("add_product.php", {variable:count,variable2: ProductId},function(data){
    }); 

}

function AddProductToCart(event){

     count=$('#CartCounter').html();
     count=parseInt(count);
     if (isNaN(count))count=0;
     count++;
      var ProductId=$(event.target).attr("class");
      if (ProductId==="zakup right")         //jesli klikamy na spana pobierz rodzica czyli<p>
        ProductId=$(event.target).parent().attr("class");
      if(ProductId==='fa fa-shopping-cart') //jesli na ikone pobierz rodzica,rodzica czyli <p>
      ProductId=$(event.target).parent().parent().attr("class"); 
     PassVarToPhpByAjax(ProductId,count);
    $('#CartCounter').html(count);
    ObjectBlinkAnimate($(".introImg .wrapper"));


}  
function ObjectBlinkAnimate(par){
    par.animate({opacity: 0},"fast" ).animate({opacity: 1} );
}

    


      $(document).ready(function(){
                   
        //funkcja pokazujaca liste rozmiarow z kolorami dla danego produktu po kliknieciu na obrazek
                $('img').click(function(){
                    //var labe;

                   if( $(this).parent().find("p").css("display")=="none")
                       $(this).parent().find("p").css({"display" : "block"});
                      
                   else $(this).parent().find("p").css({"display" : "none"});
                      //narazie niepotrzbne-pobieranie rodzaju towaru ktory zostal wybrany
                     /*labe= $(this).parent().find("label").text();
                     alert(labe); */
                 }
              );

        //funkcja pokazuje ramke przy aktywnym obrazku
            $('img').hover(function(){
                     $(this).css({
                     "border" : "2px red solid" });

                        },function(){

                          $(this).css({"border" : "none"})
                   });


        //jw ale odnosi sie do wysunietych pol listy-patrz 22
                $('.galeryWrapper>p').hover(function(){
                      $(this).css({"border" : "2px red solid" });

                         },function(){
                             $(this).css({"border" : "none"})
                    });

          //funkcja chowajaca liste(patrz 22) wymiarow i kolorow po opuszczeniu jakiegokolwiek diva z obrazkiem       
                     $('div').hover(function(){
                       },function(){

                      $('img').parent().find("p").css({"display" : "none"});
                     });
                //zakup z listy     
                    $('p').click(AddProductToCart);

     


        });
</script>
</head>
<body>
  <header id="master-header">
          <div class="logo">
            <i class="fa fa-qq"></i>
        </div>
        <div class="wrapper">
            
         
            <nav>
                <ul>

                    <li><a href="index.html">Startowa</a></li>
                    <li><a href="#">Promocje miesiaca</a></li>
                    <li><a href="#">Nowe Produkty</a></li>
                    <li><a href="#">Contact</a></li>
                  
                </ul>

            </nav>
 <a id="log" href="#">Zaloguj</a>
        </div>

    </header>

    
<div class="introImg">
      <div class='wrapper'>
        Uwaga dodano Produkt.<div id="CartCounter" class="right"><?php if(isset($_SESSION["cart_counter"]))echo $_SESSION["cart_counter"]; else echo"0";?></div><a href="koszyk.php"><span><i class="fa fa-shopping-cart"></i></span></a>
      </div>
</div>

  <div id="main2">
      
       <div class="menufilter left">
            <form method='POST' action=''>
                  <h>Pokaż tylko</h><br/>
                  <input type="checkbox" name="check1" value=" check1"/>ubrania<br/>
                  <input type="checkbox" name="check2" value=" wartosc"/>obuwie <br/>
                  <input type="checkbox" name="check3" value=" wartosc"/>akcesoria <br/><br/>
                  <input type="submit" name=" nazwa " value="filtruj"/>
            </form>
       </div>
           
        
    <div id="test" class="galery">
  <?php
  /* Filtr produktow 
   produkty wybieram na podstawie tego ze code produktu(baza sql) jest dla
ubran 1xx,dla butow 2xx a dla akcesori 3xx.
w kazdym if-ie  dwie petle foreach -pierwsza wyszukuje rodzaje produktow,druga dla tych produktow
tworzy liste szczegolowa  rozmiar-kolor
  */
  if(isset($_POST['check1']))
    foreach($productsNoRepeat as $prod):?>
       <?php if ($prod->code -200<0){?>
         <div class="inline galeryWrapper">
         <label><?php echo $prod->name?></label><br/><img id="img" src="gfx/4.jpg"/><br/>
         Cena <?php echo $prod->price;
                foreach($products as $prod2):?>
                  <?php if ($prod2->name==$prod->name ) {?> <p class="<?php echo "$prod2->id";?>"> <?php echo  $prod2->additional_note ;?><span class="zakup right">Dodaj do<i class="fa fa-shopping-cart"></i></span></p>
                <?php } endforeach;?>
         </div>
       <?php  } endforeach;

  
   if (isset($_POST['check2']))
      foreach($productsNoRepeat as $prod):?>
         <?php if ($prod->code -300<0 && $prod->code -200>0){?>
            <div class="inline galeryWrapper">
             <label><?php echo $prod->name?></label><br/><img id="img" src="gfx/4.jpg"/><br/>
             Cena <?php echo $prod->price;
                foreach($products as $prod2):?>
                  <?php if ($prod2->name==$prod->name ) {?> <p class="<?php echo "$prod2->id";?>"> <?php echo  $prod2->additional_note ;?><span class="zakup right">Dodaj do<i class="fa fa-shopping-cart"></i></span></p>
                <?php } endforeach;?>
           </div>
       <?php  } endforeach;

   
    if (isset($_POST['check3']))
      foreach($productsNoRepeat as $prod):?>
        <?php if ($prod->code -400<0 && $prod->code -300>0){?>
         <div class="inline galeryWrapper">
          <label><?php echo $prod->name?></label><br/><img id="img" src="gfx/4.jpg"/><br/>
           Cena <?php echo $prod->price;
            foreach($products as $prod2):?>
               <?php if ($prod2->name==$prod->name ) {?> <p class="<?php echo "$prod2->id";?>"> <?php echo  $prod2->additional_note ;?><span class="zakup right">Dodaj do<i class="fa fa-shopping-cart"></i></span></p>
            <?php } endforeach;?>
         </div>
      <?php  } endforeach;
   ?>

             
    </div>
      

 </div>

    <footer id="master-footer">
        <div class="wrapper">
          
            <p id="copyrights">&copy; 2015 Bartek Sadurski. All Rights Reserved.</p>

            <ul id="socials-menu">
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                <li><a href="#"><i class="fa fa-flickr"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
            </ul>

            <ul id="footer-menu">
                <li><a href="#">Faq</a></li>
                <li><a href="#">Regulamin sklepu</a></li>
                <li><a href="#">Inne sklepy</a></li>
                <li><a href="#">Koszty wysyłki</a></li>
                <li><a href="#">Kariera</a></li>
            </ul>
        </div>
        
    </footer>

</body>
</html>