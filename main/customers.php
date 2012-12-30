<script type="text/javascript">
	   
     $(document).ready(function(){
         
           
         $("#myTabs").css({'width':'47%','margin':'0 auto'});
         $("#myTabs > p").css({'font-size':'1.4em','font-weight':'bold','text-align':'center'});
         $("#tab01").css('margin', '8px auto');
         $("#tab02").hide().css({'width':'66%','margin':'12px auto'});
         $("#about_bottom").css({'width':'100%'});
         
         $(".ico-edit").mousedown(function(){
             $("#tab01").hide();
             $("#tab02").show();
             var id = this.id;
             id = id.substr(2); 
//             $("div").css({'outline':'1px solid blue'});
             $(".col50").css({'position':'relative','width':'50%','float':'left'});
             $("#right_side").css({'position':'relative','width':'50%','float':'left','padding-top':'66px'});
         });
         $(".ico-user-02").mousedown(function(){
             $("#tab01").hide();
             var id = this.id;
             id = id.substr(4);
         });
     });
     
</script>

<div id="content" class="box">   
                    <!-- Tab01 -->

    <div  class="tabs box" id="myTabs">
        <p>Клиенты.</p>
<!--        <ul>    
            <li><span><strong></strong></span></li>
        </ul>-->
    </div>

    <div id="tab01">

        <table>
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
    foreach ($customers as $value) {
        echo "<tr><td class='t-right'>$value[id]</td><td>$value[surname]&nbsp;$value[name]&nbsp;$value[patronymic]</td><td class='smaller'>$value[phone]</td><td class='smaller'>$value[email]</td><td class='smaller t-center'>$value[creation_time]</td><td class='t-center'><a id='e_$value[id]' class='ico-edit' title='Редактировать'></a><a id='set_$value[id]' class='ico-user-02' title='Выбрать контакт'></a></td></tr>";

                }
                ?>
            </tbody>
        </table>
    </div> <!-- /tab01 -->

</div>
<!-- Tab02 -->
<div id="tab02">
     
    <form action="index.php?act=user_insert" method="post" id="user_insert" name="user_insert">  
        <fieldset>
    	<legend><strong>Основные данные</strong></legend>     
        <div class="col50">
             <p><label for="surname">Фамилия:</label><br />
			    <input size="50" name="surname" value="" class="input-text required" id="surname" type="text"></p>
            <p><label for="name">Имя:</label><br />
			    <input size="50" name="name" value="" class="input-text required" id="name" type="text"></p>
             <p><label for="phone">Телефон:</label><br />
			    <input size="30" name="phone" value="" class="input-text required" id="phone" type="text"></p>
            <p><label for="fax">Факс:</label><br />
			    <input size="30" name="fax" value="" class="input-text" id="fax" type="text"></p>
        </div>
        
        <div class="col50 f-right" id="right_side">
            <p><label for="patronymic">Отчество:</label><br />
			    <input size="50" name="patronymic" value="" class="input-text" id="patronymic" type="text"></p>
            <p><label for="phone2">Дополнительный телефон:</label><br />
			    <input size="30" name="phone2" value="" class="input-text" id="phone2" type="text"></p>
            <p><label for="email">Электронная почта:</label><br />
			    <input size="30" name="email" value="" class="input-text email" id="email" type="text"></p><br />
        </div>
        <div id="about_bottom">
         <p><label for="postcode">Почтовый индекс:</label><br />
			    <input size="12" name="postcode" value="" class="input-text digits" id="postcode" minlength="6" maxlength="6" type="text"></p>
         <p><label for="address">Почтовый адрес:</label><br />
			    <input size="100" name="address" value="" class="input-text" id="address" type="text"></p>
         <p><label for="comments">Комментарии:</label><br />
			    <textarea cols="95" rows="3" class="input-text" id="comments" name="comments"></textarea></p>
         <p><label for="tags">Теги:</label><br />
			    <input size="100" name="tags" value="" class="input-text" id="tags" type="text"><br />
            <span class="smaller low">несколько тегов разделяются запятыми</span></p>
        </div>  
    
        </fieldset>
    
        <div class="box-01">
		    <p class="nom" style="text-align: center"><input value="Создать пользователя" class="input-submit" type="submit" id="user_insert_submit"></p>
		</div> 
    </form>
<!--        
        <fieldset id="fieldset_doc" style="display:none;">
    	<legend>Документы</legend>
         
        <div id="user_doc"></div>
        
             Button: Загрузка документов 
             Должна появляться в режиме редактирования 
			<p class="box"><a href="javascript:toggle('upload_1');" class="btn-create"><span>Загрузить</span></a></p>                             
             Upload 
			<div id="upload_1" class="box-01" style="display: none;">

				<form action="index.php?act=doc_add" method="post" enctype="multipart/form-data" id="doc_add" name="doc_add">  
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
                    <input type="hidden" name="query_str" value="<? echo $_SERVER["QUERY_STRING"]; ?>" />
                    <input type="hidden" name="ph" value="/user/" id="ph">
                    <input type="hidden" name="pt" value="user"   id="pt">
                    <input type="hidden" name="pc" value="id"     id="pc">
                    <input type="hidden" name="pv" value=""       id="pv">
					<input type="hidden" name="doc_type" value="1" id="doc_type">
                    
                    <p class="nomt">
						<label for="inputname" class="low">Выберите название из списка:</label><br />
						<select name="inputname" class="input-text required" id="inputname" size="7">
                            <?php option_doc($udoc);?>
                        </select>
					</p>
 
					
                    <p class="nom"><input size="62" name="userfile" class="input-text-02 required" type="file"></p>
					<br />
					<p class="nom">
						<input value="Загрузить" class="input-submit" type="submit">						
					</p>
					
				</form>

			</div>  /upload 
        
        </fieldset>-->
        
    
</div> <!-- /tab02 -->