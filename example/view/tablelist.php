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
                    echo "<tr><td class='t-left'><a class='db_table' id='".$tables[($i*4)][0]."'>".$tables[($i*4)][0]."</a></td><td class='t-left'><a class='db_table' id='".$tables[($i*4)+1][0]."'>".$tables[($i*4)+1][0]."</a></td><td class='t-left'><a class='db_table' id='".$tables[($i*4)+2][0]."'>".$tables[($i*4)+2][0]."</a></td><td class='t-left'><a class='db_table' id='".$tables[($i*4)+3][0]."'>".$tables[($i*4)+3][0]."</a></td></tr>";
                }
                
                ?>
            </tbody>            
        
        
    </div> <!-- /tab01 -->
       
            
<!--        <div id="add_db"> </div>-->

<div id="tab02">
<!--    <form id="form_add_db">
        <fieldset>  
                <div class="col50">
                    <input type="hidden" value="" id="uid"/>
                    <p><label for="surname">Data base name:</label><br />
                                    <input size="50" value="" class="input-text required" id="db_name" type="text"/></p>
                    <p><label for="name">Login:</label><br />
                                    <input size="50" value="" class="input-text required" id="db_login" type="text"/></p>
                    <p><label for="phone">Password:</label><br />
                                    <input size="30" value="" class="input-text required" id="db_password" type="text"/></p>
                    <p><label for="fax">Address:</label><br />
                                    <input size="30" value="" class="input-text" id="db_addr" type="text"/></p>
                    <p><label for="postcode">Charset:</label><br />
                                    <input size="12" value="" class="input-text digits" id="db_charset" minlength="9" maxlength="9" type="text"></p>
                </div>
        </fieldset>

        <div class="box-01" id="back_box">
            <p class="nom" style="text-align: center"><input value="Сохранить" class="input-submit" type="button" id="update_db">&nbsp;&nbsp;<input value="Вернутся" class="input-submit" type="button" id="back"></p>
        </div> 
   </form>    -->
</div> <!-- /tab02 -->
</div>
