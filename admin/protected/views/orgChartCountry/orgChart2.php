
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/orgchart/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/orgchart/css/jquery.jOrgChart.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/orgchart/css/custom.css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/orgchart/css/prettify.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/orgchart/fancybox/jquery.fancybox.css" type="text/css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<!-- jQuery includes -->
<!--  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<!--  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>-->
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/orgchart/js/prettify.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/orgchart/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/orgchart/js/jquery.jOrgChart.js"></script><!--ลิ้งปุ่ม add edit-->
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/orgchart/js/taffy.js"></script>
<style type="text/css">
  #getjson {
    width: 100px;
    height: 50px;
    border-radius: 3px;
    margin-left: 20px;
    margin-top: 20px;
  }
  /*
#chart{
    height: 300px;
    overflow: scroll;
    width: 500px;
    resize:both;
overflow:auto;
}
*/
.opciones span{
  cursor: pointer;
}
ul#upload-chart {
  float: right;
  list-style: none outside none;
}

ul#upload-chart li {
  background: none repeat scroll 0 0 #ECDC20;
  border: 1px solid #808080;
  border-radius: 2px;
  height: 44px;
  margin-top: 2px;
  padding-top: 5px;
  width: 200px;
}
</style>
<script>
  function init_tree() {
    var opts = {
     chartElement : '#chart',
     dragAndDrop  : false,
     expand       : true,
     control		 : true,
     rowcolor     : false
   };
   $("#chart").html("");
   $("#org").jOrgChart(opts);
   cutomdata();
 }

 function scroll() {
  $(".node").click(function() {
    $("#chart").scrollTop(0)
    $("#chart").scrollTop($(this).offset().top - 140);
  })
}

var click_flag = true;
var node_to_edit;
  // read json and convert to html formate
  function loadjson() {
    var items = [];
    var data = TAFFY([

      <?php
      $criteria = new CDbCriteria;
      $criteria->compare('active','y');
      $criteria->order = 'sortOrder  ASC';
      $categories=OrgChartCountry::model()->findAll($criteria);

      
      if($categories){
        foreach($categories as $n=>$category)
        {
          if($category->parent_id==""){
            $parent_null = '""';
          }else{
            $parent_null = $category->parent_id;
          }

          ?>
          {

            "id": <?=$category->id?>,
            "name": "<?=$category->title?>",
            "parent": <?=$parent_null?>,
            "level": <?=$category->level?>
          },

          <?php
        }
      }
      ?>
      ]);

    data({
      "parent": ""
    }).each(function(record, recordnumber) {
      loops(record);
    });
    //start loop the json and form the html
    function loops(root) {
      if (root.level == 1) {
        items.push("<li class='btn_add unic" + root.id + " root' id='" + root.id + "' data-parent='" + root.parent + "' data-department='"+ root.department +"'><span class='label_node'><a href='#'>" + root.name + "</a></br></span>");
      }else if (root.level == 2 &&  root.parent == 1) {
        items.push("<li class='btn_add unic" + root.id + "' id='" + root.id + "' data-parent='" + root.parent + "' data-department='"+ root.department +"'><span class='label_node'><a href='<?=Yii::app()->createUrl('Coursecontrol/index/id');?>/" + root.id + "' class='move_down' data-name='"+root.name+"' target='_blank'><span class='RootName'>" + root.name + "</span></a></br></span>");
      } else {
        // items.push("<li class='child unic" + root.id + "' id='" + root.id + "' data-parent='" + root.parent + "' data-department='"+ root.department +"'><span class='label_node'><a href='<?=Yii::app()->createUrl('Coursecontrol/index/id');?>/" + root.id + "' class='move_down' data-name='"+root.name+"' target='_blank'><span class='RootName'>" + root.name + "</span></a><p><a href='<?=Yii::app()->createUrl('Orgcontrol/index/id');?>/" + root.id + "' style='font-size: 12px' target='_blank'>แผนก</a></p></br></span>");

        items.push("<li class='child unic" + root.id + "' id='" + root.id + "' data-parent='" + root.parent + "' data-department='"+ root.department +"'><span class='label_node'><a href='<?=Yii::app()->createUrl('Coursecontrol/index/id');?>/" + root.id + "' class='move_down' data-name='"+root.name+"' target='_blank'><span class='RootName'>" + root.name + "</span></a><p><a href='<?=Yii::app()->createUrl('Orgcontrol/index/id');?>/" + root.id + "' style='font-size: 12px' target='_blank'></a></p></br></span>");
      }

      var c = data({
        "parent": root.id
      }).count();
      if (c != 0) {
        items.push("<ul>");
        data({
          "parent": root.id
        }).each(function(record, recordnumber) {
          loops(record);
        });
        items.push("</ul></li>");
      } else {
        items.push("</li>");
      }
      } // End the generate html code

    //push to html code
    $("<ul/>", {
      "id": "org",
      "style": "float:right;",
      html: items.join("")
    }).appendTo("body");
  }
</script>
</head>

<body onload="prettyPrint();">
  <!-- <button id="getjson" onclick="makeArrays()">Save</button> -->
  <div id="in" style="display:none">
  </div>

  <ul id="upload-chart"></ul>

  <div id="chart" class="orgChart"></div>
  <!-- Add Node box -->
  <div id="fancy" class="hidden">
    <form action="." method="post" id="add_node_form">
      <h1 class="title_lb">New Node</h1>
      <div class="span12" id="add_nodo">
        <p class="notice span3">
          Enter node caption
        </p>
        <input type="text" name="node_name" id="new_node_name" class="span6" />
        <div class="span12">
          <button id="add_node" class="aqua_btn span3">Add</button>
        </div>
      </div>
    </form>
  </div>
  <!-- Edit node box -->
  <div id="fancy_edit" class="hidden">
    <form action="." method="post" id="edit_node_form">
      <h1 class="title_lb">Edit Node</h1>
      <div class="span12" id="edit_nodo">
        <p class="notice span3">
          Enter node caption
        </p>
        <input type="text" name="node_name" id="edit_node_name" class="span6" />
        <div class="span12">
          <button id="edit_node" class="aqua_btn span3">Edit</button>
        </div>
      </div>
    </form>
  </div>


  <script type="text/javascript">
    function remChild(removing) {
      $("#upload-chart").append(removing);
      $("#upload-chart ul li").each(function() {
        var Orgli = $(this).removeAttr("class").addClass("node").addClass("child").clone();
        $(this).remove();
        $("#upload-chart").append(Orgli);
      });
      $("#upload-chart ul").remove();
      var sideLi = $("#upload-chart").html();
      $("#upload-chart").empty();
      $("#upload-chart").append(sideLi);
    }

    function makeArrays() {
      var level = [];

      $("#org li").each(function() {
        var uid = $(this).attr("id");
        var des = $(this).attr("data-department");
      // var name = $(this).find(">:first-child a").text();
      var name = $(this).find(">:first-child .move_down").text();
      if(name == ""){
       name = $(this).find(">:first-child a").text();
     }
     var pid = $(this).attr("data-parent");
     var hidSTR = "";
     var hid = $(this).parents("li");
      if (hid.length == 0) //If this object is the root user, substitute id with "orgName" so the DB knows it's the name of organization and not a user
      {
        hidSTR = uid;
        //hidSTR = 0;
        var arry = hidSTR.split(",");
        var user = new Object();
        user.id = uid;
        user.description = des;
        user.key = name;
        user.parent_id = pid;
        user.level = arry.length;
        level.push(user);
      } else {
        for (var i = hid.length - 1; i >= 0; i--) {
          if (i != hid.length) {
            hidSTR = hidSTR + hid[i].id + ',';
          } else {
            hidSTR = hidSTR + hid[i].id + ',';
          }
        }
        var arry = hidSTR.split(",");
        var user = new Object();
        user.id = uid;
        user.description = des;
        user.key = name;
        user.parent_id = pid;
        user.level = arry.length;
        level.push(user);
      }
    });

      console.log(level)
      $.ajax({
        type: "POST",
        url: "<?=$this->createUrl("/OrgChartCountry/saveorgchart");?>",
        data: { post_value:level },
        success: function(data){
          alert("SAVE");
          location.reload();
        },
      });
        // $.each( level, function( key, value ) {
        //     var data_text = "" + value.level + "";

        //     //แบ่ง array ด้วย ","
        //     var arry = data_text.split(",");

        //     //กรณีที่ต้องการตัดค่าว่าง array
        //     // arr = $.grep(arry, function( a ) {
        //     //   return a !== "";
        //     // });

        //       alert(value.level + ":" + arry.length);

        // });


      }

      function cutomdata() {
        var add_to_node = "",
        del_node = "",
        classList = "";
        var regx = /\w*(row)/;

        $(".edit").off("click").on("click", function(e) {
          classList = $(this).parent().parent().attr('class').split(/\s+/);
          var tipo_n;
          $.each(classList, function(index, item) {
            if (item != "temp" && item != "node" && item != "child" && item != "ui-draggable" && item != "ui-droppable" && !regx.test(item)) {
              del_node = item;
            }
            if (item == "root" || item == "child") {
              tipo_n = item;
            }
          });
          node_to_edit = $("li." + del_node + ":not('.temp')");
          $("#edit_node").off("click").on("click", function(e) {
            e.preventDefault();
        //modify li and refresh tree
        var edit_field = $("#edit_node_name");
        var edit_title = $("#edit_node_title");
        var texto = edit_field.val();
        var texti = edit_title.val();
        node_to_edit.find("> .label_node:eq(0) > a").text(texto);
        node_to_edit.find("> .label_node:eq(0) > i").text(texti);
        edit_field.val("");
        edit_title.val("");
        $.fancybox.close();
        init_tree();

      });
        }).fancybox({
          maxWidth: 800,
          maxHeight: 800,
          fitToView: false,
          width: '70%',
          height: '70%',
          autoSize: false,
          closeClick: false,
          openEffect: 'none',
          closeEffect: 'none'
        });


    //-- Listo editar :D

    $(".del").off("click").on("click", function(e) {
      if(confirm("Are you sure?")){
        var nodo = $(this);
        if (!nodo.parent().parent().hasClass("temp")) {
          var nodeDiv = nodo.parent().parent();
          var cu = nodeDiv.find("a").attr("rel");
          classList = nodeDiv.attr('class').split(/\s+/);
          $.each(classList, function(index, item) {
            if (item != "temp" && item != "node" && item != "child" && item != "ui-draggable" && item != "ui-droppable" && !regx.test(item)) {
              del_node = item;
            }
          });
          var element = $("li." + del_node + ":not('.temp, #upload-chart li')").removeAttr("class").addClass("node").addClass("child");
          remChild(element);
          init_tree();
        }
      }

    });

    $(".add").off("click").on("click", function() {
      click_flag = false;

      classList = $(this).parent().parent().attr('class').split(/\s+/);
      $.each(classList, function(index, item) {
        if (item != "temp" && item != "node" && item != "child" && item != "ui-draggable" && item != "ui-droppable" && !regx.test(item)) {
          add_to_node = item;
        }
      });
      $("#add_node").off("click").on("click", function(e) {
        e.preventDefault();

        //unidad de consumo agregada, agregar li a la lista, y refrescar arbol
        var res = add_to_node.substring(4);
        var tipo_nodo = "";
        var text_field = $("#new_node_name");
        var text_description = $("#new_node_title");
        var texto = text_field.val();
        var texti = text_description.val();
        text_field.val("");
        text_description.val("");
        var $node = $("li." + add_to_node + ":not('.temp')");
        var childs = $("#org li").size() + $("#upload-chart li").size() + 1;
        tipo_nodo += "child unic" + childs;
        var append_text = "<li class='" + tipo_nodo + "' data-parent='" + res + "' data-department='"+ texti +"'>";
        append_text += "<span class='label_node'><a href='#'>" + texto + "</a></span>";
        append_text += "</li>";
        if ($node.find("ul").size() == 0) {
          append_text = "<ul>" + append_text + "</ul>";
          $node.append(append_text);
        } else {
          $node.find("ul:eq(0)").append(append_text);
        }

        $.fancybox.close();
        init_tree();
        scroll()
      });

    }).fancybox({
      maxWidth: 800,
      maxHeight: 800,
      fitToView: false,
      width: '70%',
      height: '70%',
      autoSize: false,
      closeClick: false,
      openEffect: 'none',
      closeEffect: 'none',
      afterClose: function() {
        click_flag = true;
        init_tree()
      }
    });
  }


  $(document).ready(function() {
    /* Custom jQuery for the example */
    $("#show-list").click(function(e) {
      e.preventDefault();

      $('#list-html').toggle('fast', function() {
        $('#list-html').text($('#org').html());
        $("#org").bind("DOMSubtreeModified", function() {
          $('#list-html').text('');
          $('#list-html').text($('#org').html());
          prettyPrint();
        });
        if ($(this).is(':visible')) {
          $('#show-list').text('Hide underlying list.');
          $(".topbar").fadeTo('fast', 0.9);
        } else {
          $('#show-list').text('Show underlying list.');
          $(".topbar").fadeTo('fast', 1);
        }
      });
    });



    loadjson();
    init_tree();

    //forms behavior
    $("#new_node_name, #edit_node_name").on("keyup", function(evt) {
      var id = $(this).attr("id");
      if ($(this).val() != '') {
        if (id == "new_node_name") {
          $("#add_node").show();
        } else {
          $("#edit_node").show();
        }
      } else {
        if (id == "new_node_name") {
          $("#add_node").hide();
        } else {
          $("#edit_node").hide();
        }
      }
    });
    scroll();


  });
</script>


