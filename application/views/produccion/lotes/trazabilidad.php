<style>
  .center-arbol {
    display: block;
    margin-right: auto;
    margin-left: auto;
  }

  .scrolls {
    overflow-x: scroll;
    overflow-y: hidden;
    /* height: 80px; */
    white-space: nowrap
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
    </div>
  </div>
  <div class="row" hidden>
    <div class="box box-warning">
      <div class="box-header">
        <a class="btn btn-social-icon btn-vk pull-left" onclick="print('tree')"><i class="fa fa-print"></i></a>
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-toggle="collapse" data-target="#boxTree" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body panel-collapse collapse in" id="boxTree" aria-expanded="true">
        <div id="tree" class="scrolls">
        </div>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <div class="row" hidden>
    <div class="box box-default">
      <div class="box-header">
        <a class="btn btn-social-icon btn-vk pull-left" onclick="print('tabla')"><i class="fa fa-print"></i></a>
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-toggle="collapse" data-target="#boxTabla" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body panel-collapse collapse in" id="boxTabla" aria-expanded="true">
        <table id="tabla" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th style="width: 8%;">Cod. Lote</th>
              <th>Estado</th>
              <th style="width: 10%;">N° Orden</th>
              <th>Etapa</th>
              <th>Recipiente</th>
              <th>Articulo</th>
              <th style="width: 10%;">Path</th>
              <th style="width: 10%;">Alta lote</th>
            </tr>
          </thead>
          <tbody id="tbodyTabla">

          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
</section>
<!-- jHTree -->
<!-- <script src="<?php echo base_url(); ?>lib\plugins\jHTree\js\jquery-ui-1.10.4.custom.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/plugins/jHTree/CSS/jHTree.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/plugins/jHTree/Themes/black-tie/jquery-ui-1.10.4.custom.min.css">
<script src="<?php echo base_url(); ?>lib\plugins\jHTree\js\jQuery.jHTree.js"></script> -->
<script src="<?php echo base_url(); ?>lib\plugins\jasonday-printThis-f73ca19\printThis.js"></script>

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
        $('#tree').parents('div .row').prop('hidden', '');
        $('#tabla').parents('div .row').prop('hidden', '');
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
        crearTabla(rsp.data);
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

    // $("#tree").jHTree({
    //   callType: 'obj',
    //   structureObj: nodos,
    //   zoomer: true
    // });
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
    // $("#tree").jHTree({
    // callType: 'obj',
    // structureObj: myData,
    // zoomer: false
    // });
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
      array[i]['contents'] = "Estado: " + data[i].lote_estado + "<br>Alta: " + data[i].lote_fec_alta + "<br>Etapa: " + data[i].etap_nombre + "<br>Recipiente: " + data[i].reci_nombre + "<br>Tipo: " + data[i].reci_tipo;
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
          aux3[h]['contents'] = "Estado: " + o.lote_estado + "<br>Alta: " + o.lote_fec_alta + "<br>Etapa: " + o.etap_nombre + "<br>Recipiente: " + o.reci_nombre + "<br>Tipo: " + o.reci_tipo;
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

  function crearTabla(data) {
    var datosTabla = '';
    for (let i = 0; i < data.length; i++) {
      datosTabla += "<tr>" +
        "<td>" + data[i].lote_id + "</td>" +
        "<td>" + data[i].lote_estado + "</td>" +
        "<td>" + data[i].lote_num_orden_prod + "</td>" +
        "<td>" + data[i].etap_nombre + "</td>" +
        "<td>" + data[i].reci_nombre + "</td>" +
        "<td>" + data[i].arti_descripcion + "</td>" +
        "<td>" + data[i].path + "</td>" +
        "<td>" + data[i].lote_fec_alta + "</td>" +
        "</tr>";
    }
    console.log('datosTabla');
    console.log(datosTabla);
    $('#tbodyTabla').html(datosTabla);
    // $('#tabla').dataTable();
    DataTable('#tabla');
  }

  function print(id) {
    console.log('id: ' + id);
    $("#" + id).printThis({
      debug: false, // show the iframe for debugging
      importCSS: true, // import parent page css
      importStyle: false, // import style tags
      printContainer: true, // print outer container/$.selector
      loadCSS: "", // path to additional css file - use an array [] for multiple
      pageTitle: "", // add title to print page
      removeInline: false, // remove inline styles from print elements
      removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline must be true
      printDelay: 333, // variable print delay
      header: null, // prefix to html
      footer: null, // postfix to html
      base: false, // preserve the BASE tag or accept a string for the URL
      formValues: true, // preserve input/form values
      canvas: false, // copy canvas content
      doctypeString: 'Informe de Trazabilidad', // enter a different doctype for older markup
      removeScripts: false, // remove script tags from print content
      copyTagClasses: false, // copy classes from the html & body tag
      beforePrintEvent: null, // function for printEvent in iframe
      beforePrint: null, // function called before iframe is filled
      afterPrint: null // function called before iframe is removed
    });
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