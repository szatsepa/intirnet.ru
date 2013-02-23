<div id="content" class="box"> 
      <input type="hidden" id="uid" value="">
      <input type="hidden" id="str_addr" value="<?php echo $_SERVER [QUERY_STRING];?>">
      <input type="hidden" id="db_i" value="<?php echo $attributes[db_id];?>">
      <input type="hidden" id="db_t" value="<?php echo $attributes[db_tablename];?>">
      <input type="hidden" id="is_table" value="<?php echo $count_f;?>">
      <input type="hidden" id="customers" value='<?php echo $j_customers;?>'>
      <input type="hidden" id="db_n" value="<?php echo $dbname;?>">
      <input type="hidden" id="db_s" value="<?php echo $attributes[db_server];?>">
      <input type="hidden" id="db_l" value="<?php echo $attributes[db_login];?>">
      <input type="hidden" id="db_p" value="<?php echo $attributes[db_pwd];?>">
      <input type="hidden" id="db_c" value="<?php echo $attributes[db_charset];?>">
      

<!-- Tab01 -->
    <br><br>
    <p class="box" id="chap"><strong>Tаблицa базы данных - <?php echo $attributes['db_tablename'];?>.</strong></p>
                    
    <div  class="tabs box" id="myTabs">
        <ul> 
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
            } 
            reset($this_fields);
            ?> 
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($this_fields as $value){
                echo "<td class='t-left'>$fields_sinonim[$value]</td>";
            }?>
        </tr>
    </tbody>
</table>


        
</div> <!-- /tab01 -->
    <div id="tab02"> 
        <br><p><input type="button" id="save_fields" value="Запомнить псевдонимы полей"></p>
    </div> 
<!--    /tab02 -->
</div>
