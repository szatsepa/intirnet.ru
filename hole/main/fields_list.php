<?php
$fieldlist = new FieldSelect();

$selects = $fieldlist->fieldSelect(intval($attributes['tid']), intval($attributes['db_id']));

$tablefields = $fieldlist->getFieldsOfTable(intval($attributes['tid']), intval($attributes['db_id']));

?>
<div id="content" class="box"> 
      <input type="hidden" id="uid" value="<?php echo $user['id'];?>">
      <input type="hidden" id="str_addr" value="<?php echo $_SERVER ['QUERY_STRING'];?>">
      <input type="hidden" id="db_i" value="<?php echo $attributes['db_id'];?>">
      <input type="hidden" id="db_t" value="<?php echo $attributes['table'];?>">
      <input type="hidden" id="tid" value="<?php echo $attributes['tid'];?>">
      

<!-- Tab01 -->
    <br><br>
    <p class="box" id="chap">Tаблицa - <strong>"<?php echo $attributes['table'];?>".</strong></p>
                    
    <div  class="tabs box" id="myTabs">
        <ul> 
            <form id="finde_form">
                <li>
                    <label for="fields">
                        &nbsp;&nbsp;&nbsp;Выберите поле&nbsp;&nbsp;&nbsp;&nbsp;
                        </label>
                        <select id="fields">
                        <?php
                        $num = 0;
                        
                        foreach ($selects as $value) {
                            if($value['this_name'] !== ''){
                                echo '<option value="'.$value['field_name'].'">'.$value['field_name'].'</option>';
                                $num++;
                            }                            
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input id="find_string" value="">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input id="find_btn" type="button" value="Искать">
                </li>
            </form>
        </ul>
        <?php
        if($num !== 0){
                echo '<input type="hidden" id="is_select" value="1">';
            }else{
                echo '<input type="hidden" id="is_select" value="0">';
            }
        ?>
    </div>

    <div id="tab01">
<!--            <ul class="box"> </ul>-->
                
                <table id="db_tab">
            <thead>
                <tr>
<!--                    <th class="t-center">I</th>-->
                    <?php
//                    foreach ($tablefields as $value){ 
//                   } 
                   ?>
                        
                    
                    <th class="t-center">Название поля</th>
                    <th class="t-center">Синоним поля</th>
                    <th class="t-center">&nbsp;&nbsp;</th>
                   
                </tr>

            </thead> 
            <tbody>
                
                <?php 
reset($tablefields);

$nums = 0;
                    foreach ($tablefields as $value) {
                        
                        echo $fieldlist->getSinonim(intval($attributes['tid']), intval($attributes['db_id']), $value, $nums);
                        
                       
                        $nums++;
                    }
                ?>
                    
            </tbody>            
                </table>

<br><br>
<table id="customer_t">
    <thead>
        <tr>

        </tr>
    </thead>
    <tbody>
        <tr>

        </tr>
    </tbody>
</table>
        
</div> <!-- /tab01 -->
    <div id="tab02"> 
        <br><p><input type="button" id="save_fields" value="Запомнить псевдонимы полей"></p>
    </div> 
<!--    /tab02 -->
</div>
