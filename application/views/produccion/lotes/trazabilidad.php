<style>
  .center-arbol {
    display: block;
    margin-right: auto;
    margin-left: auto;
  }
</style>
<section class="content">
  <div class="row">
    <div class="box box-primary">
      <div class="box-header">
        <h3>Informe de Trazabilidad</h3>
      </div>
      <div class="box-body">
        <div class=" form-group col-sm-5">
          <div class="col-sm-2">
            <h4>Lote</h4>
          </div>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="batch" name="batch" placeholder="Ingrese código de batch">
          </div>
          <div class="col-sm-3">
            <button type="button" class="btn btn-block btn-primary btn-flat" onclick="buscarBatch()">Buscar</button>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-sm-12 col-md-12 col-lg-12">
        <!-- lote_id(codigo), estado, num_orden_prod, fec_alta, nombre etapa, nombre recipiente, tipo recipiente, estado recipiente -->
        <!-- <div id="themes">
            <span id="changeItUp">Change Theme</span>
            <div id="set">
              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/smoothness/jquery-ui-1.10.4.custom.min.css" title="Smoothness">
                <img src="lib/plugins/jHTree/images/themethumbs/themenail_smoothness.png" alt="image" width="25" height="22">
              </a>
              <a href="<?php echo base_url(); ?>lib/plugins/jHTree/Themes/black-tie/jquery-ui-1.10.4.custom.min.css" title="blacktie">
                <img src="lib/plugins/jHTree/images/themethumbs/themenail_blacktie.png" alt="image" width="25" height="22">
              </a>

              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/south-street/jquery-ui-1.10.4.custom.min.css" title="South Street">
                <img src="lib/plugins/jHTree/images/themethumbs/themenail_southst.png" alt="image" width="25" height="22">
              </a>

              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/mint-choc/jquery-ui-1.10.4.custom.min.css" title="Mint Choco">
                <img src="lib/plugins/jHTree/images/themethumbs/themenail_mintchoc.png" alt="image" width="25" height="22">
              </a>

              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/dot-luv/jquery-ui-1.10.4.custom.min.css" title="Dot Luv">
                <img src="lib/plugins/jHTree/images/themethumbs/themenail_dotluv.png" alt="image" width="25" height="22">
              </a>

              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/humanity/jquery-ui-1.10.4.custom.min.css" title="humanity">
                <img src="lib/plugins/jHTree/images/themethumbs/humanity.png" alt="image" width="25" height="22">
              </a>
              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/cupertino/jquery-ui-1.10.4.custom.min.css" title="Cupertino">
                <img src="lib/plugins/jHTree/images/themethumbs/themenail_cupertino.png" alt="image" width="25" height="22">
              </a>
              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/le-frog/jquery-ui-1.10.4.custom.min.css" title="le-frog">
                <img src="lib/plugins/jHTree/images/themethumbs/le-frog.png" alt="image" width="25" height="22">
              </a>
              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/swanky-purse/jquery-ui-1.10.4.custom.min.css" title="swanky-purse">
                <img src="lib/plugins/jHTree/images/themethumbs/swanky-purse.png" alt="image" width="25" height="22">
              </a>

              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/trontastic/jquery-ui-1.10.4.custom.min.css" title="trontastic">
                <img src="lib/plugins/jHTree/images/themethumbs/trontastic.png" alt="image" width="25" height="22">
              </a>

              <a href="<?php echo base_url(); ?> lib/plugins/jHTree/Themes/ui-lightness/jquery-ui-1.10.4.custom.min.css" title="lightness">
                <img src="lib/plugins/jHTree/images/themethumbs/lightness.png" alt="image" width="25" height="22">
              </a>
            </div>
          </div> -->
        <div id="tree">

        </div>
      </div>
    </div>
  </div>
</section>
<!-- jHTree -->
<!-- <script src="<?php echo base_url(); ?>lib\plugins\jHTree\js\jquery-ui-1.10.4.custom.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/plugins/jHTree/CSS/jHTree.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/plugins/jHTree/Themes/black-tie/jquery-ui-1.10.4.custom.min.css">
<script src="<?php echo base_url(); ?>lib\plugins\jHTree\js\jQuery.jHTree.js"></script> -->

<script>
  function buscarBatch() {
    var nodos = '';
    var batch = $('#batch').val();
    // wo();
    $.ajax({
      type: 'GET',
      data: {
        batch: batch
      },
      dataType: 'JSON',
      url: 'general/Lote/trazabilidadBatch',
      success: function(rsp) {
        console.log(rsp.data);
        var aux = [];
        rsp.data.forEach(function(e) {
          if (!aux[e.batch_id_padre]) aux[e.batch_id_padre] = [];
          aux[e.batch_id_padre].push(e);
          // console.log(e);
        });

        // console.log(aux);
        // return;
        var reducido = reduceDatos(rsp.data, aux);
        nodos = formarJson(rsp.data, reducido);
        ttt(nodos);
        // list_to_tree(cuerpo);
      },
      error: function(rsp) {
        alert("No se encontró batch! Intente nuevamente.");
      },
      complete: function(rsp) {
        // wc();
      }
    })
  }

  function ttt(nodos) {
    console.log('nodosssss');
    console.log(nodos);
    // var nodos = [{
    //   "head": "asd",
    //   "id": "padre",
    //   "contents": "Estado: ",
    //   "children": "asd",
    //   "children": [{
    //       "head": "Batch_id: 2",
    //       "id": "2",
    //       "contents": "asd2",
    //       "children": [{
    //         "head": "Batch_id: 3",
    //         "id": "3",
    //         "contents": "asd3"
    //       }]
    //     },
    //     {
    //       "head": "Batch_id: 4",
    //       "id": "4",
    //       "contents": "asd4",
    //       "children": [{
    //           "head": "Batch_id: 5",
    //           "id": "5",
    //           "contents": "asd5"
    //         },
    //         {
    //           "head": "Batch_id: 6",
    //           "id": "6",
    //           "contents": "asd6"
    //         }
    //       ]
    //     }
    //   ]
    // }]
    // console.log('nodosssss');
    // console.log(nodos);
    $("#tree").jHTree({
      callType: 'obj',
      structureObj: nodos,
      nodeDropComplete: function(event, data) {
        //----- Do Something @ Server side or client side -----------
        // alert("Node ID: " + 4 + " Parent Node ID: " + 6);
        //-----------------------------------------------------------
      }
    });
    return;
  }

  function crearArbol(data, i = 0) {
    // var val = 4;
    // var data = JSON.parse(data);
    if (data) {
      var padre = data[i].batch_id;
      var hijo = data[i].batch_id_padre;
      var children = new array();
      children[i]['head'].push(data[i + 1].lote_id);
      children[i]['id'].push(data[i + 1].batch_id);
      var contents = "Estado: " + data[i + 1].lote_estado + "<br>Alta: " + data[i + 1].lote_fec_alta + "<br>Recipiente: " + data[i + 1].reci_nombre + "<br>Tipo: " + data[i + 1].reci_tipo;
      children[i]['contents'].push(contents);
      // children = convertirHijo(data[0], children);
      crearArbol(data, i);
    } else {
      i++
      return;
    }
    // var nodos = [{
    //   "head": data[0].lote_id,
    //   "id": padre,
    //   "contents": "Estado: " + data[0].lote_estado + "<br>Alta: " + data[0].lote_fec_alta + "<br>Recipiente: " + data[0].reci_nombre + "<br>Tipo: " + data[0].reci_tipo,
    //   "children": hijos(data, data[0].batch_id),
    //   "children": [{
    //       "head": "Batch_id: 2",
    //       "id": "2",
    //       "contents": "asd2",
    //       "children": [{
    //         "head": "Batch_id: 3",
    //         "id": "3",
    //         "contents": "asd3"
    //       }]
    //     },
    //     {
    //       "head": "Batch_id: 4",
    //       "id": "4",
    //       "contents": "asd4",
    //       "children": [{
    //           "head": "Batch_id: 5",
    //           "id": "5",
    //           "contents": "asd5"
    //         },
    //         {
    //           "head": "Batch_id: 6",
    //           "id": "6",
    //           "contents": "asd6"
    //         }
    //       ]
    //     }
    //   ]
    // }]

    // $("#tree").jHTree({
    //   callType: 'obj',
    //   structureObj: nodos,
    //   nodeDropComplete: function(event, data) {
    //     //----- Do Something @ Server side or client side -----------
    //     // alert("Node ID: " + 4 + " Parent Node ID: " + 6);
    //     //-----------------------------------------------------------
    //   }
    // });
  }

  function convertirHijo(data) {
    var children = new array();
    children['head'].push(data.lote_id);
    children['id'].push(data.batch_id);
    var contents = "Estado: " + data[0].lote_estado + "<br>Alta: " + data[0].lote_fec_alta + "<br>Recipiente: " + data[0].reci_nombre + "<br>Tipo: " + data[0].reci_tipo;
    children['contents'].push(contents);
    children['children'].push(hijo);
    return children;
  }

  function arbolito(data) {
    var nodo = new array();
    var head, id, contents;
    nodo = [{
      "head": data[0].lote_id,
      "id": data[0].batch_id,
      "contents": "Estado: " + data[0].lote_estado + "<br>Alta: " + data[0].lote_fec_alta + "<br>Recipiente: " + data[0].reci_nombre + "<br>Tipo: " + data[0].reci_tipo
    }];
    var i = 0;
    while (i < data.length) {
      var hijo = new array();
      var j = 1;
      while (j < data.length || [i].batch_id == data[j].batch_id_padre) {
        hijo['head'] = data[j].lote_id;
        hijo['id'] = data[j].batch_id;
        hijo['contents'] = "Estado: " + data[j].lote_estado + "<br>Alta: " + data[j].lote_fec_alta + "<br>Recipiente: " + data[j].reci_nombre + "<br>Tipo: " + data[j].reci_tipo;
        nodo.children = hijo;
        j++;
      }
      i++;
    }

    var nodo = [{
      "head": data[0].lote_id,
      "id": data[0].batch_id,
      "contents": "Estado: " + data[0].lote_estado + "<br>Alta: " + data[0].lote_fec_alta + "<br>Recipiente: " + data[0].reci_nombre + "<br>Tipo: " + data[0].reci_tipo,
      "children": arbolRecursivo(data, data[1]),
    }];
  }

  function abc(data) {
    var nodos = list_to_tree(data);
    $("#tree").jHTree({
      callType: 'obj',
      structureObj: nodos,
      nodeDropComplete: function(event, data) {
        //----- Do Something @ Server side or client side -----------
        // alert("Node ID: " + 4 + " Parent Node ID: " + 6);
        //-----------------------------------------------------------
      }
    });
  }

  function list_to_tree(list) {
    var map = {},
      node, roots = [],
      i;

    for (i = 0; i < list.length; i += 1) {
      map[list[i].id] = i; // initialize the map
      list[i].children = []; // initialize the children
    }

    for (i = 0; i < list.length; i += 1) {
      node = list[i];
      if (node.batch_id_padre !== "0") {
        // if you have dangling branches check that map[node.batch_id_padre] exists
        list[map[node.batch_id_padre]].children.push(node);
      } else {
        roots.push(node);
      }
    }
    console.log(roots);
    return roots;
  }

  function reduceDatos(data, aux) {
    var array = [data.length];
    console.table(array);
    for (let i = 0; i < data.length; i++) {
      array[i] = new Array();
      array[i]['head'] = data[i].lote_id;
      array[i]['id'] = data[i].batch_id;
      array[i]['contents'] = "Estado: " + data[0].lote_estado + "<br>Alta: " + data[0].lote_fec_alta + "<br>Recipiente: " + data[0].reci_nombre + "<br>Tipo: " + data[0].reci_tipo;
      array[i]['children'] = aux[data[i].batch_id];
      // array[i]['children'] = [];

      // if (!data[i].batch_id_padre) {
      //   array[i]
      // }

      // if (!aux[e.batch_id_padre]) aux[e.batch_id_padre] = [];
      // aux[e.batch_id_padre].push(e);
      // console.log(e);
    }
    var aux2 = [];
    array.forEach(function(e) {
      if (!(!e.children || e.children == null || e.children == '' || e.children == 'undefined')) {
        aux2[e.id] = [];
        var aux3 = [];
        var h = 0;
        e.children.forEach(function(o) {
          aux3[h] = [];
          aux3[h]['head'] = o.lote_id;
          aux3[h]['id'] = o.batch_id;
          aux3[h]['contents'] = "Estado: " + o.lote_estado + "<br>Alta: " + o.lote_fec_alta + "<br>Recipiente: " + o.reci_nombre + "<br>Tipo: " + o.reci_tipo;
          // aux3[h]['children'] = '';
          // aux2[e.id].push(aux3[h]);
          h++;
        })
      }
    });
    console.log(aux2);
    for (let i = 0; i < data.length; i++) {
      var id = array[i]['id'];
      array[i]['children'] = aux2[id];
    }

    console.log('array:');
    console.log(array);
    return array;
  }

  function formarJson(entero, reducido) {
    // console.log('reducido: ');
    // console.log(reducido);
    for (let i = entero.length - 2; i >= 0; i--) {
      console.log("reducido[i]['children']: ");
      console.log(reducido[i]['children']);
      for (let j = i + 1; j < entero.length; j++) {
        if (entero[i].batch_id == entero[j].batch_id_padre) {
          var o = Object.assign({}, reducido[j])
          reducido[i]['children'].push(o);
        }
      }
    }
    var data = Object.assign({}, reducido[0]);
    console.log('data: ');
    console.log(data);
    console.table(data);
    var rsp = JSON.stringify(reducido[0]);
    // rsp = JSON.parse(rsp);
    console.log('rsp: ');
    console.log(rsp);
    console.table(rsp);

    var array = [];
    array.push(data);
    // console.log('array');
    // console.log(array);
    var json = JSON.stringify(array);
    console.log('json');
    console.log(json);
    // var json = '';
    // $.ajax({
    //   type: 'GET',
    //   data: data,
    //   dataType: 'JSON',
    //   url: 'general/Lote/convertToJson',
    //   success: function(data) {
    //     var array = [];
    //     array.push(data);
    //     console.log('array');
    //     console.log(array);
    //     json = JSON.stringify(array);
    //   }
    // })
    return array;
  }


  // $("#tree").jHTree({
  //   callType: 'obj',
  //   structureObj: myData,
  //   zoomer: false
  // });

  // $('.zmrcntr').addClass('hidden');

  // var _gaq = _gaq || [];
  // _gaq.push(['_setAccount', 'UA-36251023-1']);
  // _gaq.push(['_setDomainName', 'jqueryscript.net']);
  // _gaq.push(['_trackPageview']);

  // (function() {
  //   var ga = document.createElement('script');
  //   ga.type = 'text/javascript';
  //   ga.async = true;
  //   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  //   var s = document.getElementsByTagName('script')[0];
  //   s.parentNode.insertBefore(ga, s);
  // })();
</script>