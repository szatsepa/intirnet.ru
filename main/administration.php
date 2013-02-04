<div id="content" class="box">   
                    <!-- Tab01 -->
      <input type="hidden" id="uid" value="">
      <input type="hidden" id="str_addr" value="<?php echo $_SERVER [QUERY_STRING];?>">
        <br><br>
                    
        <p class="box" id="chap"><strong>Администрация.</strong></p>
<!--        <p class="box" id="p-filter" style="display:none;"><a id="a_role" class="btn-info"><span>Роли</span></a><a id="a_alphabet" class="btn-info"><span>Алфавит</span></a><a id="a_all" class="btn-info"><span>Все</span></a></p>            -->
    
<!-- Upload -->
<!--<fieldset id="fieldset_filter_roles">-->
<!--</fieldset>-->

<!-- Upload --> 
<!--<fieldset id="fieldset_filter_alphabet">
</fieldset> -->
                    
            

    <div  class="tabs box" id="myTabs">
        <p>&nbsp;</p>

    </div>

    <div id="tab01">

        <table id="customers_tab">
            <thead>

            </thead> 
            <tbody>
                <tr>
                    <th class="t-center">ID</th>
                    <th class="t-center">Ф.И.О.</th>
                    <th class="t-center">Телефон</th>
                    <th class="t-center">Email</th>
                    <th class="t-center">Дата<br />рег.</th>
                    <th class='t-center'>Действ.</th>
                </tr>
    <?php
    foreach ($users as $value) {
        echo "<tr id='r_$value[id]'><td class='t-right'>$value[id]</td><td>$value[surname]&nbsp;$value[name]&nbsp;$value[patronymic]</td><td class='smaller'>$value[phone]</td><td class='smaller'>$value[email]</td><td class='smaller t-center'>$value[creation_time]</td><td class='t-center'><a id='e_$value[id]' class='ico-edit' title='Редактировать'></a><a id='set_$value[id]' class='ico-user-02' title='Выбрать контакт'></a></td></tr>";

                }
                ?>
            </tbody>
        </table>
        <br>
        <p class="nom" style="text-align: center"><input value="Добавить" class="input-submit" type="button" id="add_new_user"></p>
    </div> <!-- /tab01 -->


    <!-- TAB02 -->
    <div id="tab02">
            <fieldset>
    	<legend>Основные данные</legend>     
        <div class="col50" id="cu_h">
             <p><label for="surname">Фамилия:</label><br />
			    <input value="" class="input-text required" id="surname" type="text"></p>
            <p><label for="patronymic">Отчество:</label><br />
			    <input value="" class="input-text" id="patronymic" type="text"></p>
             <p><label for="phone">Телефон:</label><br />
			    <input value="" class="input-text required" id="phone" type="text"></p>
        </div>
        
        <div class="col50 f-right" id="cu_f">
            <p><label for="name">Имя:</label><br />
			    <input value="" class="input-text required" id="name" type="text"></p>
            
            <p><label for="role">Роль:</label><br />
                            <input value="" class="input-text" id="role"></p>
            <p><label for="email">Электронная почта:</label><br />
			    <input value="" class="input-text email" id="email" type="text"></p><br />
        </div>
        </fieldset>
                    <div class="box-01">
                        <p class="nom"><input value="Сохранить пользователя" class="input-submit" type="button" id="user_insert_submit"></p>
                    </div> 


            <fieldset id="fieldset_doc" style="display:none;">        

    </div> <!-- /tab02 -->

</div>
