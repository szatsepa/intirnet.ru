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
    <p class="box" id="chap"><strong>Tаблицa базы данных - <?php echo $attributes[db_tablename];?>.</strong></p>
                    
    <div  class="tabs box" id="myTabs">
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
            </thead> 
            <tbody>
                <?php 
                    foreach ($rows as $value) {
                        echo "<tr id='r_$value[id]'>";
                        
                        foreach ($fields_name as $key) {
                            echo "<td class='t-left'>$value[$key]</td>";
                        }
                        
                        echo "</tr>";
                    }
                ?>
            </tbody>            
        
        
    </div> <!-- /tab01 -->
    <div id="tab02">

    </div> <!-- /tab02 -->
</div>
