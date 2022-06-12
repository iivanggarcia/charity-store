$(document).ready(function(){
    console.log("Sí entro");
    $(".addCarrito").click(function(){
      let usr=$(this).attr("data-usr");
      let prod=$(this).attr("data-prod");
      $.ajax({
        url: "pages/addCarrito.php",
        method: "post",
        data: {usuario:usr,producto:prod},
        cache: false,
        success:function(respAX){
          let AX = JSON.parse(respAX);
          let tipo;
          if(AX.codigo == 1) tipo = "green"; else tipo = "red";
          $.alert({
            title: 'Aviso',
            content: AX.mensaje,
            type: tipo,
            icon: 'fas fa-info-circle fa-2x',
            boxWidth: '50%',
            useBootstrap: false,
        });
        }
      });
    });
  });