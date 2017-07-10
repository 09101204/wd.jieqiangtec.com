function $(id) {
	return document.getElementById?document.getElementById(id):document.all?d.all[id]:document.layers[id];
}
function input_onkeydown(e){
  var keycode=isIE==1?e.keyCode:e.which;
  if(keycode==13){
    e.returnValue=false;
    send();
  }
}
function saveas() {
  try {
    var savestyle='<style type="text/css"> <!--body{margin: 0px; padding: 0px 0px 0px 0px; border: 0px;FONT-SIZE: 9pt; FONT-FAMILY: Tahoma;}.im_to{color:#008040;height:18px;line-height:18px;}.im_from{color:#0000ff;height:18px;line-height:18px;}.im_content{color:#000000;padding-left:10px;}.im_tip{color:#0000ff;}.error{color:#7982c1;height:18px;line-height:18px;padding-left:20px;background:url(im_info.gif) no-repeat 2px 1px;}--></style>';
    var time=new Date();
    var filename=time.toLocaleDateString();
    filename=filename+" "+(document.title.toString().replace(/\s/g,'_'))+".htm";
    var winSave=window.open('about:blank','_blank','top=10000');
    winSave.document.open("text/html","utf-8");
		winSave.document.write("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><base target=\"_blank\">"+savestyle+"</head><body>"+$("showbox").outerHTML+"</body></html>");
    winSave.document.execCommand ("SaveAs",true,filename);
    winSave.close();
  }
  catch(e){}
}

function ubbtohtml(fdata){
  fdata=fdata.replace(new RegExp(':([a-zA-Z]+)_([0-9]{1,2})','g'),'<img src="../images/smiley/$1/s_$1_$2.gif">');
  fdata=fdata.replace(new RegExp('\\[url\\](www.|http:\/\/){1}([^\[\"\']+?)\\[\/url\\]','gi'),'<a href="$1$2" target="_blank">$1$2</a>');
  fdata=fdata.replace(new RegExp('\\[url=(www.|http:\/\/){1}([^\[\"\']+?)\\](.+?)\\[\/url\\]','gi'),'<a href="$1$2" target="_blank">$3</a>');
  fdata=fdata.replace(new RegExp('\\[img\\]([^\[\"\']+?)\.(gif|jpg|bmp|png){1}\\[\/img\\]','gi'),'<img src="$1.$2" />');
  return fdata;
}
function inserturl(){
	var url = prompt(Lang['inserturl'],'http://');
	if(url==null || url=='' || url=='http://'){
    $('inputbox').focus();
    return false;
	}
  $('inputbox').value+='[url]'+url+'[/url]';
  $('inputbox').focus();
}
function insertpic(){
	var url = prompt(Lang['insertpic'],'http://');
	if(url==null || url=='' || url=='http://'){
    $('inputbox').focus();
    return false;
	}
  $('inputbox').value+='[img]'+url+'[/img]';
  $('inputbox').focus();
}
function insertimageurl(){
  CloseAllDiv();
  $('imagediv').style.display='';
}
function getimage(e){
  var keycode=isIE==1?e.keyCode:e.which;
  if(keycode==13){
    e.returnValue=false;
    if($('insertimage').value.length<1)return;
    $('inputbox').value+='[img]'+$('insertimage').value+'[/img]';
    $('insertimage').value="";
    CloseAllDiv();
  }
}
function getimage2(){
  if($('insertimage').value.length<1)return;
  $('inputbox').value+='[img]'+$('insertimage').value+'[/img]';
  $('insertimage').value="";
  CloseAllDiv();
}
function NewTime(d){
	var date = new Date(d.getTime()+TimeAdd);
	//Y_=date.getYear().toString();
	//m_=date.getMonth().toString();
	//d_=date.getDay().toString();
	H_=date.getHours().toString();
	i_=date.getMinutes().toString();
	s_=date.getSeconds().toString();
	//if(m_.length==1)m_="0"+m_;
	//if(d_.length==1)d_="0"+d_;
	if(H_.length==1)H_="0"+H_;
	if(i_.length==1)i_="0"+i_;
	if(s_.length==1)s_="0"+s_;
	//return Y_+"-"+m_+"-"+d_+" "+H_+":"+i_+":"+s_;
	return H_+":"+i_+":"+s_;
}
function KeyDown(){
	if (window.event.keyCode == 116){	
		event.keyCode = 0;
		event.returnValue = false;
	}
}
document.onkeydown = KeyDown;
function SwfInit(){
  try{
    myFlashObj = isIE ? myFlash : document.myFlash;
    myFlashObj.SetVariable("BaseUrl", homepage+'service/getdata.php');
    myFlashObj.SetVariable("Cid", cid);
    myFlashObj.SetVariable("Wid", wid);
    myFlashObj.SetVariable("Lt", lt);
    myFlashObj.SendMsg('load');
    PrintChat('s','',Tip,'im_sys');
  }catch(e){
    setTimeout("SwfInit()",100);
  }
}
SwfInit();
if (navigator.appName && navigator.appName.indexOf("Microsoft") != -1 && navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1){
  document.write('<SCRIPT LANGUAGE=VBScript\> \n');
  document.write('on error resume next \n');
  document.write('Sub myFlash_FSCommand(ByVal command, ByVal args)\n');
  document.write(' call myFlash_DoFSCommand(command, args)\n');
  document.write('end sub\n');
  document.write('</SCRIPT\> \n');
}
function SetCount(ctype,cindex){
  if(ctype=='w'){
    OpenDialog('company',cindex,ChatType=='s'?false:true);
    var obj=$('last_company_'+cindex+'_num');
  }else if(ctype=='u'){
    OpenDialog('client',cindex,ChatType=='s'?false:true);
    var obj=$('last_client_'+cindex+'_num');
  }else if(ctype=='p'){
    OpenDialog('public',cindex,ChatType=='s'?false:true);
    var obj=$('last_public_'+cindex+'_num');
  }else{
    return;
  }
  if(obj==null)return;
  if(ctype==ChatType && cindex==ChatIndex){
    obj.innerHTML='';
  }else{
    var num=obj.innerHTML.toString().replace('(','').replace(')','');
    num=num.length<1?1:(parseInt(num)+1);
    obj.innerHTML='('+num+')';
  }
}
function PrintChat(ctype,cindex,str,cname,newid,notsave){
  if(ctype=='s'){
    str='['+Now()+']'+str;
  }
  if(ctype==ChatType && cindex==ChatIndex){
    var e=document.createElement('div');
    if(cname!='')e.className=cname;
    if(newid!='')e.id=newid;
    e.innerHTML=str;
    $('showbox').appendChild(e);
    ScrollControl();
  }
  if(!notsave){
    SaveChat(ctype,cindex,str,cname);
  }
  if(cname=='im_from')SetCount(ctype,cindex);
}
function SaveChat(ctype,cindex,str,cname){
  var tmp='<div'+(cname==''?'':' class="'+cname+'"')+'>'+str+'</div>';
  if(ctype=='w'){
    Worker[cindex]['msg']+=tmp;
  }else if(ctype=='u'){
    Client[cindex]['msg']+=tmp;
  }else if(ctype=='p'){
    PublicMsg+=tmp;
  }else {
    SystemMsg+=tmp;
  }
}
function ScrollControl(){
	$('showbox').scrollTop+=50000;
}
function Now(){
	var date = new Date();
	H_=date.getHours().toString();
	i_=date.getMinutes().toString();
	s_=date.getSeconds().toString();
	if(i_.length==1)i_="0"+i_;
	if(s_.length==1)s_="0"+s_;
	return H_+":"+i_+":"+s_;
}
function send(){
  var message=$('inputbox').value;
  message=message.replace(/\n/g,'');
	message=message.replace(new RegExp('<scr'+'ipt[^>]*?>.*?</scr'+'ipt>','g'), "") ;
	message=message.replace(new RegExp('\<\!\-\-.*?\-\-\>','g'), "") ;
	message=message.replace('\<\!\-\-', "") ;
  if(message.length<1){
    $('inputbox').value='';
    $('inputbox').focus();
    return false;
  }
  var uType=ChatType;
  var uName=myname;
  try{
    if(IsSuper){
      if(ChatType=='u'){
        uName=$('AccountList').options[$('AccountList').selectedIndex].value;
        uType="C&"+$('AccountList').selectedIndex;
      }
    }
  }catch(e){}
  PrintChat(ChatType,ChatIndex,uName+"  " + Now(),'im_to');
  PrintChat(ChatType,ChatIndex,ubbtohtml(message),'im_content');
  myFlashObj.SendMsg('send,'+cid+','+wid+','+uType+','+ChatIndex+','+escape(uName)+','+escape(message));
  $('inputbox').value='';
  $('inputbox').focus();
}
function HitListTi(obj,token,e){
  if(e.button==1){
    if(obj.className=='list_open'){
      obj.className='list_close';
      $(token+'list').style.display='none';
    }else{
      obj.className='list_open';
      $(token+'list').style.display='block';
    }
  }else if(e.button==2){
    
  }
}
function window_onload(){
  try{$('inputbox').focus();}catch(e){}
  var tmp='<ul>';
  for(var i=0;i<smileys.length;i++){
    tmp+='<li id="t_'+i+'" onclick="sel_smiley_g('+i+')">'+smileys[i][0]+'</li>';
  }
  tmp+='</ul>';
  $('s_title').innerHTML=tmp;
  drag($('myweb'));
}
function sel_smiley_g(index){
  if(index==-1){
    index=cursmiley;
  }
  for(var i=0;i<smileys.length;i++){
    if(i==index){
      $('t_'+i).className='sel';
      var tmp='<ul>';
      for(var k=smileys[i][2];k<=smileys[i][3];k++){
        tmp+='<li><img src="../images/smiley/'+smileys[i][1]+'/s_'+smileys[i][1]+'_'+k+'.gif" onclick="sel_smiley('+k+')" /></li>';
      }
      tmp+='</ul>';
      $('s_content').innerHTML=tmp;
      $('smiley').style.display='';
      var t=-$('s_content').offsetHeight-$('inputdiv').offsetHeight-$('toolbardiv').offsetHeight-$('dialogtitle').offsetHeight;
      if(isIE){
        $('smiley').style.pixelTop=t;
      }else{
        $('smiley').style.top=t+"px";
      }
      cursmiley=index;
    }else{
      $('t_'+i).className='';
    }
  }
}
function sel_smiley(index){
  $('inputbox').value+=':'+smileys[cursmiley][1]+'_'+index;
  CloseAllDiv();
}
function CloseAllDiv(){
  $('smiley').style.display='none';
  $('upload').style.display='none';
  $('imagediv').style.display='none';
}
function tmpInput(e){
  if(ChatType=='w' || ChatType=='u'){
    myFlashObj.SendMsg('myinput,'+cid+','+wid+','+ChatIndex);
  }
}
function _GET(tmpdata,thekey){
  if(tmpdata.substr(0,1)!='&')tmpdata='&'+tmpdata;
  if(tmpdata.indexOf('&'+thekey+'=')==-1)return'';
  var o=tmpdata.split('&'+thekey+'=');
  o=o[1].split('&');
  try{
    return unescape(o[0]);
  }catch(e){
    return o[0];
  }
}
function OpenTip(msg,hiddentime){
  $("sysmsg").innerHTML=msg+(hiddentime?'':'('+Now()+')');
}
function AddUser(group,userid,username,classname){
  var obj=$(group+'list');
  var e=document.createElement('li');
  e.id=group+'_'+userid;
  e.innerHTML='<span class="user" onclick="OpenDialog(\''+group+'\',\''+userid+'\')">'+username+'</span>';
  if(classname){
    e.className=classname;
  }
  obj.insertBefore(e,obj.children.length>0?obj.children[0]:null);
}
function OpenDialog(group,userid,hidden){
  var username='';
  var eid='last_'+group+'_'+userid;
  var e=document.createElement('li');
  e.id=eid;
  try{e.className=$(group+'_'+userid).className;}catch(e_){}
  if(group=='company'){
    if(!hidden){
      $('dialogtitle').innerHTML=language['108']+' &raquo; '+language['109']+Worker[userid]['realname']+language['105']+'('+language['110']+':'+userid+')';
      $('showbox').innerHTML=Worker[userid]['msg'];
      ChatType='w';
      ChatIndex=userid;
      try{$('last_company_'+userid+'_num').innerHTML=''}catch(e_){}
      LoadInfo('w',userid);
      $('toolbar_change').style.display='none';
      $('toolbar_history').style.display='none';
      $('closebtn').style.display='block';
    }
    username=Worker[userid]['realname'];
  }else if(group=='client'){
    if(!hidden){
      $('dialogtitle').innerHTML=language['108']+' &raquo; '+language['111']+Client[userid]['address']+'['+Client[userid]['ip']+']'+language['112']+'('+language['110']+':'+userid+')';
      $('showbox').innerHTML=Client[userid]['msg'];
      ChatType='u';
      ChatIndex=userid;
      try{$('last_client_'+userid+'_num').innerHTML=''}catch(e_){}
      LoadInfo('u',userid);
      $('toolbar_change').style.display='block';
      $('toolbar_history').style.display='block';
      $('closebtn').style.display='block';
    }
    username=Client[userid]['nickname'];
  }else if(group=='public'){
    if(!hidden){
      $('dialogtitle').innerHTML=language['108']+' &raquo; '+language['061']+'('+language['113']+')';
      $('showbox').innerHTML=PublicMsg;
      ChatType='p';
      ChatIndex='';
      try{$('lastpublic_'+userid+'_num').innerHTML=''}catch(e_){}
      LoadInfo('p','');
      $('toolbar_change').style.display='none';
      $('toolbar_history').style.display='none';
      $('closebtn').style.display='block';
    }
    username=language['061'];
  }
  $('inputdiv').className='input';
  $('inputbox').style.display='block';
  $('inputbtn').style.display='block';
  $('toolbarlist').style.display='block';
  $('inputbox').focus();
  
	ScrollControl();
  e.innerHTML='<a href="#" onclick="OpenDialog(\''+group+'\',\''+userid+'\')">'+username+'</a><span class="count" id="'+eid+'_num"></span> <span class="close" onclick="CloseDialog(\''+eid+'\')" title="'+language['066']+'"></span>';
  if($(eid)==null){
    $('lastlist').insertBefore(e,$('lastlist').children.length>0?$('lastlist').children[0]:null);
  }else if($('lastlist').children.length>1){
    var a=$(eid);
    var b=a.cloneNode(true);
    $('lastlist').insertBefore(b,$('lastlist').children[0]);
    $('lastlist').removeChild(a);
  }
  $('count_last').innerHTML=$('lastlist').children.length;
}
function CloseCur(){
  if(ChatType=='w'){
    CloseDialog('last_company_'+ChatIndex);
  }else if(ChatType=='u'){
    CloseDialog('last_client_'+ChatIndex);
  }else if(ChatType=='p'){
    CloseDialog('last_public_'+ChatIndex);
  }
}
function CloseDialog(idname){
  try{$('lastlist').removeChild($(idname));}catch(e){}
  $('dialogtitle').innerHTML=language['065'];
  $('showbox').innerHTML=SystemMsg;
  $('inputdiv').className='input disabled';
  $('inputbox').style.display='none';
  $('inputbtn').style.display='none';
  $('toolbarlist').style.display='none';
  $('closebtn').style.display='none';
  $('count_last').innerHTML=$('lastlist').children.length;
  ChatType='s';
  ChatIndex='';
	ScrollControl();
  LoadInfo('s','');
}
function LoadInfo(ctype,userid){
  if($('coB').style.display=='none')return;
  if(ctype!='w' && ctype!='u'){
    $('UserInfo').className='userinfo';
    $('UserInfo').innerHTML=language['114'];
    return;
  }
  $('UserInfo').className='loading';
  $('UserInfo').innerHTML='';
  myFlashObj.SendMsg('loadinfo,'+cid+','+ctype+','+userid);
}
function myFlash_DoFSCommand(command, args) {
  if(args!="undefined" && args!=""){
    //PrintChat('s','','command:'+command+'; args:'+args);
    if(command=="get"){
      var cmd=_GET(args,'cmd');
      var fdata=_GET(args,'fdata');
      if(cmd=='list'){
        UidsB=UidsA;
        var o=fdata.split("<E>");
        for(i=0;i<o.length;i++){
          var e=o[i].split('|');
          if(e[0]=='1'){
            if($('company_'+e[1])==null){
              e[5]=e[5].length>0?e[5]:e[2];
              Worker[e[1]]=new Object();
              Worker[e[1]]['nickname']=e[2];
              Worker[e[1]]['class']='offline';
              Worker[e[1]]['msg']='';
              Worker[e[1]]['realname']=e[5];
              AddUser('company',e[1],e[5],'w_'+e[4]);
              $('count_company').innerHTML=parseInt($('count_company').innerHTML)+1;
            }
            if(Worker[e[1]]['class']=='online' && e[4]=='offline'){
              OpenTip(language['109']+Worker[e[1]]['realname']+language['115']);
              PrintChat('s','',language['109']+Worker[e[1]]['realname']+language['115'],'im_sys');
              $('count_company').innerHTML=parseInt($('count_company').innerHTML)-1;
              try{$('last_company_'+t[j]).className='w_offline'}catch(e_){}
              $('company_'+e[1]).className='w_'+e[4];
            }else if(Worker[e[1]]['class']=='offline' && e[4]=='online'){
              OpenTip('<a href="#" onclick="OpenDialog(\'company\',\''+e[1]+'\')">'+language['109']+Worker[e[1]]['realname']+language['116']+'</a>');
              PrintChat('s','','<a href="#" onclick="OpenDialog(\'company\',\''+e[1]+'\')">'+language['109']+Worker[e[1]]['realname']+language['116']+'</a>','im_sys');
              $('count_company').innerHTML=parseInt($('count_company').innerHTML)+1;
              try{$('last_company_'+t[j]).className='w_online'}catch(e_){}
              $('company_'+e[1]).className='w_'+e[4];
            }
            Worker[e[1]]['online']=e[3];
            Worker[e[1]]['class']=e[4];
          }else if(e[0]=='2'){
            if($('client_'+e[2])==null){
              Client[e[2]]=new Object();
              Client[e[2]]['id']=e[1];
              Client[e[2]]['ip']=e[3];
              Client[e[2]]['address']=e[4];
              Client[e[2]]['thispage']=e[5];
              Client[e[2]]['msg']='';
              Client[e[2]]['nickname']=language['033']+e[2];
              AddUser('client',e[2],Client[e[2]]['nickname'],'u_online');
              try{$('last_client_'+e[2]).className='u_online'}catch(e_){}
              $('count_client').innerHTML=parseInt($('count_client').innerHTML)+1;
              UidsA=UidsA+(','+e[2]);
              OpenTip('<a href="#" onclick="OpenDialog(\'client\',\''+e[2]+'\')">'+language['111']+Client[e[2]]['address']+'('+language['110']+e[2]+')'+language['117']+'</a>');
              PrintChat('s','','<a href="#" onclick="OpenDialog(\'client\',\''+e[2]+'\')">'+language['111']+Client[e[2]]['address']+'('+language['110']+e[2]+')'+language['117']+'</a>','im_sys');
              PlaySound('newuser');
            }else{
              UidsB=UidsB.replace(','+e[2],'');
              Client[e[2]]['thispage']=e[5];
              Client[e[2]]['input']=e[6];
              if(ChatType=='u' && ChatIndex==e[2] && e[6].length>1){
                OpenTip(language['118']+' &raquo; '+unescape(e[6]),true);
              }
            }
          }
        }
        if(UidsB.length>1){
          var t=UidsB.split(',');
          for(j=0;j<t.length;j++){
            if(t[j].length>0){
              try{$('last_client_'+t[j]).className='u_offline'}catch(e_){}
              try{$('clientlist').removeChild($('client_'+t[j]));}catch(e_){}
              $('count_client').innerHTML=parseInt($('count_client').innerHTML)-1;
              OpenTip(language['111']+Client[t[j]]['address']+'('+language['110']+t[j]+')'+language['119']);
              PrintChat('s','',language['111']+Client[t[j]]['address']+'('+language['110']+t[j]+')'+language['119'],'im_sys');
              UidsA=UidsA.replace(','+t[j],'');
            }
          }
        }
      }else if(cmd=='get'){
        var o=fdata.split('{MK}');
        for(i=0;i<o.length;i++){
          var e=fdata.split('<E>');
          if(e.length>4){
            switch(e[3]){
              case '2':
                var ni=e[0].split(',');
                if($('client_'+ni[0])==null){
                  Client[ni[0]]=new Object();
                  Client[ni[0]]['nickname']=language['033']+ni[0];
                  AddUser('client',ni[0],Client[ni[0]]['nickname'],'u_online');
                }
                var mk='';
                try{
                  if(ni.length>1){
                    $('AccountList').selectedIndex=ni[1];
                    mk='->'+$('AccountList').options[$('AccountList').selectedIndex].value;
                  }
                }catch(e_){}
                var t=e[2].replace(/\+/g,',').replace(/\-/g,',').replace(/\s/g,',').replace(/:/g,',').split(',');
                OpenTip(language['033']+ni[0]+language['120']);
                PrintChat('u',ni[0],Client[ni[0]]['nickname']+mk+"  " + NewTime(new Date(t[0],t[1],t[2],t[3],t[4],t[5])),'im_from');
                PrintChat('u',ni[0],e[1],'im_content');
                PlaySound('msg');
                break;
              case '3':
                if($('company_'+e[0])==null){
                  Worker[e[0]]=new Object();
                  Worker[e[0]]['nickname']=language['121'];
                  Worker[e[0]]['realname']=language['121'];
                  AddUser('company',e[0],Worker[e[0]]['nickname'],'w_online');
                }
                if(e[1].substr(0,7)=='eqmk://'){
                  var z=e[1].split('.');
                  if(z[1]=='regchange'){
                    OpenDialog('company',e[0]);
                    PrintChat('w',e[0],Worker[e[0]]['realname']+language['122']+z[2]+language['123']+'!<a href="#" onclick="AgreeChange(\'agree\',\''+e[0]+'\',\''+z[2]+'\')">'+language['124']+'</a> <a href="#" onclick="AgreeChange(\'notagree\',\''+e[0]+'\',\''+z[2]+'\')">'+language['125']+'</a>','im_info','changediv_'+ChatType+'_'+ChatIndex,true);
                  }else if(z[1]=='agreechange'){
                    if(z[2]=='agree'){
                      PrintChat('w',e[0],Worker[e[0]]['realname']+language['126'],'im_info');
                    }else{
                      PrintChat('w',e[0],Worker[e[0]]['realname']+language['127'],'im_info');
                    }
                  }
                }else{
                  var t=e[2].replace(/\-/g,',').replace(/\s/g,',').replace(/:/g,',').split(',');
                  OpenTip(language['109']+Worker[e[0]]['realname']+language['128']);
                  PrintChat('w',e[0],Worker[e[0]]['realname']+"  " + NewTime(new Date(t[0],t[1],t[2],t[3],t[4],t[5])),'im_from');
                  PrintChat('w',e[0],e[1],'im_content');
                }
                PlaySound('msg');
                break;
              case '5':
                if(e[1]=='eqmk_repeat_login'){
                  myFlashObj.SetVariable("Token", '');
                  ForceClosed=true;
                  alert(language['129']+','+language['130']+'!');
                  window.close();
                  return;
                }else if(e[1]=='eqmk_force_logout'){
                  myFlashObj.SetVariable("Token", '');
                  ForceClosed=true;
                  alert(language['131']);
                  window.close();
                  return;
                }else if(e[1]=='book'){
                  OpenTip('<a href="#" onclick="OpenUrl(\'book.php\')">'+language['132']+'</a>');
                  PrintChat('s','','<a href="#" onclick="OpenUrl(\'book.php\')">'+language['132']+'</a>','im_sys');
                  PlaySound('system');
                }else if(e[1]=='phone'){
                  OpenTip('<a href="#" onclick="OpenUrl(\'phone.php\')">'+language['134']+'</a>');
                  PrintChat('s','','<a href="#" onclick="OpenUrl(\'phone.php\')">'+language['134']+'</a>','im_sys');
                  PlaySound('system');
                }else if(e[1]=='order'){
                  OpenTip('<a href="#" onclick="OpenUrl(\'order.php\')">'+language['135']+'</a>');
                  PrintChat('s','','<a href="#" onclick="OpenUrl(\'order.php\')">'+language['135']+'</a>','im_sys');
                  PlaySound('system');
                }else{
                  OpenTip(e[1]);
                  PrintChat('s','',e[1],'im_sys');
                  PlaySound('system');
                }
                break;
              case '6':
                if($('company_'+e[0])==null){
                  Worker[e[0]]=new Object();
                  Worker[e[0]]['realname']=language['121'];
                  AddUser('company',e[0],Worker[e[0]]['realname'],'w_online');
                }
                var t=e[2].replace(/\-/g,',').replace(/\s/g,',').replace(/:/g,',').split(',');
                OpenTip(language['023']+Worker[e[0]]['realname']+language['136']);
                PrintChat('p','',Worker[e[0]]['realname']+"  " + NewTime(new Date(t[0],t[1],t[2],t[3],t[4],t[5])),'im_from');
                PrintChat('p','',e[1],'im_content');
                break;
            }
          }
        }
      }
    }else if(command=="msg"){
      var cmd=_GET(args,'cmd');
      var fdata=_GET(args,'fdata');
      switch(cmd){
        case 'loadinfo':
          $('UserInfo').className='userinfo';
          $('UserInfo').innerHTML=fdata;
          break;
        case '':
          break;
      }
    }
  }
}
function changekefu(){
  try{$('showbox').removeChild($('onlinekefu_'+ChatType+'_'+ChatIndex))}catch(e){}
  var tmp='<ul>';
  var online=0;
  var o=$('companylist').children;
  if(o.length>=1){
    for(i=0;i<o.length;i++){
      var id=o[i].id.replace('company_','');
      if(Worker[id]['class']=='online'){
        online++;
        tmp+='<li onclick="ToKefu(\''+id+'\')">'+Worker[id]['realname']+'</li>';
      }
    }
  }
  if(online>0){
    tmp+='</ul>';
    PrintChat(ChatType,ChatIndex,'<span>'+language['137']+'</span>'+tmp,'im_change','onlinekefu_'+ChatType+'_'+ChatIndex,true);
  }else{
    PrintChat(ChatType,ChatIndex,language['138'],'im_error');
  }
}
function SetLimit(id,s){
  if(s=='1'){
    PrintChat(ChatType,ChatIndex,language['139'],'im_info');
  }else{
    PrintChat(ChatType,ChatIndex,language['140'],'im_info');
  }
  myFlashObj.SendMsg('limit,'+cid+','+wid+','+id+','+s);
}
function ToKefu(id){
  try{$('showbox').removeChild($('onlinekefu_'+ChatType+'_'+ChatIndex))}catch(e){}
  PrintChat(ChatType,ChatIndex,language['141'],'im_info');
  myFlashObj.SendMsg('regchange,'+cid+','+wid+','+ChatIndex+','+id);
}
function AgreeChange(result,workerid,userid){
  if(result=='agree'){
    PrintChat(ChatType,ChatIndex,language['142']+Worker[workerid]['realname']+language['143'],'im_info');
  }else{
    PrintChat(ChatType,ChatIndex,language['144']+Worker[workerid]['realname']+language['143'],'im_info');
  }
  $('changediv_'+ChatType+'_'+ChatIndex).innerHTML=$('changediv_'+ChatType+'_'+ChatIndex).innerText;
  myFlashObj.SendMsg('agreechange,'+cid+','+wid+','+userid+','+workerid+','+result);
}
function history(){
  OpenUrl('history.php?uid='+ChatIndex);
}
function OpenUrl(url){
  var w=600;
  var h=400;
  if(isIE){
    $("myweb_div").style.pixelWidth=document.documentElement.scrollWidth;
    $("myweb_div").style.pixelHeight=document.documentElement.scrollHeight>document.documentElement.clientHeight?document.documentElement.scrollHeight:document.documentElement.clientHeight;
    $("myweb").style.pixelWidth=w;
    $("myweb").style.pixelHeight=h;
    $("myweb").style.pixelLeft=document.documentElement.scrollLeft+parseInt(($("myweb_div").style.pixelWidth-w)/2);
    $("myweb").style.pixelTop=document.documentElement.scrollTop+parseInt(($("myweb_div").style.pixelHeight-h)/2);
  }else{
    $("myweb_div").style.width=document.documentElement.scrollWidth;
    $("myweb_div").style.height=document.documentElement.scrollHeight>document.documentElement.clientHeight?document.documentElement.scrollHeight:document.documentElement.clientHeight;
    $("myweb").style.width=w;
    $("myweb").style.height=h;
    $("myweb").style.left=document.documentElement.scrollLeft+parseInt(($("myweb_div").style.pixelWidth-w)/2);+"px";
    $("myweb").style.top=document.documentElement.scrollTop+parseInt(($("myweb_div").style.pixelHeight-ht)/2)+"px";
  }
  $("myweb").style.display='block';
  $("myweb_div").style.display='block';
  document.myweburl.location.href=url;
}
function CloseUrl(){
  $("myweb").style.display='none';
  $("myweb_div").style.display='none';
}
function MenuOvr(id){
  $('m'+id).className='sel';
}
function MenuOut(id){
  $('m'+id).className='';
}
function MenuClick(id){
  switch(id){
    case 1:
      window.open('../member/manage.php?action=getcode','member','');
      break;
    case 2:
      window.open('../member/manage.php','member','');
      break;
    case 3:
      OpenUrl('book.php');
      break;
    case 4:
      if(confirm(language['145'])){
        window.open('../member/logout.php','member','');
        window.close();
      }
      break;
    case 5:
      OpenUrl('phone.php');
      break;
    case 6:
      OpenUrl('order.php');
      break;
    case 7:
      OpenUrl('limit.php');
      break;
  }
}
function InfoClick(s){
  if(s=='A'){
    $('btnA').className='sel';
    $('coA').style.display='';
    $('btnB').className='';
    $('coB').style.display='none';
  }else if(s=='B'){
    $('btnA').className='';
    $('coA').style.display='none';
    $('btnB').className='sel';
    $('coB').style.display='';
    LoadInfo(ChatType,ChatIndex);
  }
}
function PlaySound(s){
  if($('soundbox').checked){
    return;
  }
  $('thesound_'+s).play();
}
function drag(o){
	o.onmousedown=function(a){
		var d=document;if(!a)a=window.event;
		var x=a.layerX?a.layerX:a.offsetX,y=a.layerY?a.layerY:a.offsetY;
		if(o.setCapture)
			o.setCapture();
		else if(window.captureEvents)
			window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);

		d.onmousemove=function(a){
			if(!a)a=window.event;
			if(!a.pageX)a.pageX=a.clientX;
			if(!a.pageY)a.pageY=a.clientY;
			var tx=a.pageX-x,ty=a.pageY-y;
			var pX=isIE ? document.body.scrollLeft : pageXOffset;
			var pY=isIE ? document.body.scrollTop : pageYOffset;
			o.style.left=pX + tx;
			o.style.top=pY + ty;
			if(o.id=='frame_div'){
        frame_startX=tx;
        frame_startY=ty;
      }else if(o.id=='invite_div'){
        invite1_startX=tx;
        invite1_startY=ty;
      }
		};

		d.onmouseup=function(){
			if(o.releaseCapture)
				o.releaseCapture();
			else if(window.captureEvents)
				window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
			d.onmousemove=null;
			d.onmouseup=null;
		};
	};
}
var ForceClosed=false;
function window_beforeunload(){
  if(!ForceClosed){
    window.event.returnValue=language['146'];
  }
}