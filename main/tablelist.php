<?php 
$count_tables = count($tables);

$rows = ceil($count_tables/4);

?>
<div id="content" class="box">   
      <input type="hidden" id="uid" value="">
      <input type="hidden" id="str_addr" value="<?php echo $_SERVER [QUERY_STRING];?>">
      <input type="hidden" id="db_n" value="<?php echo $dbname;?>">
      <input type="hidden" id="db_s" value="<?php echo $attributes[db_server];?>">
      <input type="hidden" id="db_l" value="<?php echo $attributes[db_login];?>">
      <input type="hidden" id="db_p" value="<?php echo $attributes[db_pwd];?>">
      <input type="hidden" id="db_c" value="<?php echo $attributes[db_charset];?>">
      <input type="hidden" id="db_i" value="<?php echo $attributes[db_id];?>">
<!-- Tab01 -->
    <br><br>
    <p class="box" id="chap"><strong>Список таблиц базы данных - <?php echo $dbname;?>.</strong></p>
                    
    <div  class="tabs box" id="myTabs">
    </div>

    <div id="tab01">
<!--            <ul class="box"> </ul>-->
                
                <table id="db_tab">
            <thead>
                <tr>
                    <th class="t-center">I</th>
                    <th class="t-center">II</th>
                    <th class="t-center">III</th>
                    <th class="t-center">IV</th>
                </tr>
            </thead> 
            <tbody>
                <?php
                for($i=0;$i<$rows;$i++){
                    $style_1 = $style_2 = $style_3 = $style_4 = '';
                    $checked_1 = $checked_2 = $checked_3 = $checked_4 = '';
                    
                    if(in_array($tables[($i*4)][0], $is_tables)){$style_1 = "style='background-color: #afffaf'";$checked_1 = 'checked';}
                    if(in_array($tables[($i*4)+1][0], $is_tables)){$style_2 = "style='background-color: #afffaf'";$checked_2 = 'checked';}
                    if(in_array($tables[($i*4)+2][0], $is_tables)){$style_3 = "style='background-color: #afffaf'";$checked_3 = 'checked';}
                    if(in_array($tables[($i*4)+3][0], $is_tables)){$style_4 = "style='background-color: #afffaf'";$checked_4 = 'checked';}
                    echo "<tr><td class='t-left' $style_1><input type='checkbox' id='".$tables[($i*4)][0]."' title='Отметить таблицу' $checked_1>&nbsp;<a class='db_table' id='".$tables[($i*4)][0]."'>".$tables[($i*4)][0]."</a></td><td class='t-left' $style_2><input type='checkbox' id='".$tables[($i*4)+1][0]."' title='Отметить таблицу' $checked_2>&nbsp;<a class='db_table' id='".$tables[($i*4)+1][0]."'>".$tables[($i*4)+1][0]."</a></td><td class='t-left' $style_3><input type='checkbox' id='".$tables[($i*4)+2][0]."' title='Отметить таблицу' $checked_3>&nbsp;<a class='db_table' id='".$tables[($i*4)+2][0]."'>".$tables[($i*4)+2][0]."</a></td><td class='t-left' $style_4><input type='checkbox' id='".$tables[($i*4+3)][0]."' title='Отметить таблицу' $checked_4>&nbsp;<a class='db_table' id='".$tables[($i*4)+3][0]."'>".$tables[($i*4)+3][0]."</a></td></tr>";
                 }
                
                ?>
            </tbody> 
                </table>
     </div> <!-- /tab01 -->

    <div id="tab02">
      
                
<!--             <div class="box-01" id="back_box"></div>-->
                <fieldset>
                    <p class="nom" style="text-align: center"><input value="Запомнить таблицы" class="input-submit" type="button" id="add_tables"></p> 
                </fieldset>
         
            
          
    </div> <!-- /tab02 -->

</div>