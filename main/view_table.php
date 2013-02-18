<div id="content" class="box">   
      <input type="hidden" id="uid" value="">
      <input type="hidden" id="str_addr" value="<?php echo $_SERVER [QUERY_STRING];?>">
      <input type="hidden" id="db_i" value="<?php echo $attributes[db_id];?>">
      <input type="hidden" id="db_t" value="<?php echo $attributes[db_tablename];?>">
      <input type="hidden" id="is_table" value="<?php echo $f_table->isTables($attributes[db_tablename]);?>">
<!--      <form id="this_fields">
          <?php
          foreach ($this_fields as $value) {
//              echo "<input type='hidden' name='$value' value='$value'>";
          }
          ?>
      </form>-->
<!-- Tab01 -->
    <br><br>
    <p class="box" id="chap"><strong>Tаблицa базы данных - <?php echo $attributes[db_tablename];?>.</strong></p>
                    
    <div  class="tabs box" id="myTabs">
        <ul> 
<!--            <li><a id="t01"><span>Список</span></a></li>-->
<!--            <a id="t03"><span>Поиск</span></a>-->
            <form id="finde_form">
                <li>Выберите поле&nbsp;&nbsp;&nbsp;&nbsp;<select id="fields">
                        <?php
                        foreach ($fields_name as $value) {
                            echo '<option value="'.$value.'">'.$value.'</option>';
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;<input id="find_string" value="">&nbsp;&nbsp;&nbsp;&nbsp;<input id="find_btn" type="button" value="Искать"></li>
    <!--            <li><a id="t04"><span><img src="../design/circle.gif" width="27" height="27"></span></a></li>-->
            </form>
        </ul>
    </div>

    <div id="tab01">
<!--            <ul class="box"> </ul>-->
                
                <table id="db_tab">
            <thead>
                <tr>
<!--                    <th class="t-center">I</th>-->
                    <?php foreach ($fields_name as $value){
                        ?>
                    
                    <th class="t-center"><?php echo $value;?></th>
                    
                   <?php 
                   } ?>
                </tr>
<!--                <tr>
                    <?php //
 foreach ($fields_name as $value) {
//     echo "<td class='t-center'></td>";
 }
                    ?>
                </tr>-->
            </thead> 
            <tbody>
                <?php 
                    foreach ($rows as $value) {
                        echo "<tr id='r_$value[id]'>";
                        
                        foreach ($fields_name as $key) {
                            echo "<td class='t-left'>$value[$key]</td>";
                        }
                        
                        echo "</tr>";
                        break;
                    }
                ?>
            </tbody>            
                </table>

<br><br>
<table id="customer_t">
    <thead>
        <tr>
           <?php foreach ($this_fields as $value){
                ?>

            <th class="t-center"><?php echo $value;?></th>

            <?php 
            } ?> 
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($this_fields as $var){
                echo "<td class='t-left'></td>";
            }?>
        </tr>
    </tbody>
</table>


        
</div> <!-- /tab01 -->
    <div id="tab02"> 
        <br><input type="button" id="save_fields" value="Запомнить псевдоним поля">
    </div> 
<!--    /tab02 -->
</div>
