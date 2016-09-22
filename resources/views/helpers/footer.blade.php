 <style>
    #footer{
        background: #0f1116;
        
        width:100%;
        padding-top:50px;
        border-bottom:6px solid #13c6ec ;
    }

    #footer .left,#footer .menu{
        display:inline-block;
        vertical-align: top;
        margin-bottom:50px;
    }
    #footer .left{
        width:250px;
        height:100%;
    }
    #footer .left div{
        color:#dddddd;
    }
    #footer .menu{
        width:755px;
        height:100%;
    }
    #footer .menu ul{
        margin-left:20px;
        padding-right:40px;
        display: inline-block;
        vertical-align: top;
    }
    #footer .menu ul a{
        color: #747b8d;
        display:block;
        width:100%;
        height:100%;
    }
    #footer .menu ul a:hover{
        color: #e5a401;
    }
    
    
    #footer .menu ul a::before {
        color: #747b8d;
        content: "• ";
        font-size: 20px;
        padding-right: 2px;
    }
    
    #footer .menu ul div{
        color:#d3d5d4;
        font-size:20px;
    }
    #footer .left .logo{
        display:block;
        background: url('/images/logo.png');
        width:186px;
        height:48px;
    }
    .copyright{
        text-align: center;
        height:30px;
        background: #dddddd;
    }
</style>
<div id='footer'>
   <div class='container'>
       <div class='left'>
           <a href='' class='logo'></a>
           <div>тел: 0636009642</div>
           <div>E-mail: s.sivinyuk@gmail.com</div>
       </div>
       <div class='menu'>
           <ul>
               <div class="title">Раздел1</div>
               <li><a href=''>Пункт 1</a></li>
               <li><a href=''>Пункт 2</a></li>
               <li><a href=''>Пункт 3</a></li>
               <li><a href=''>Пункт 4</a></li>
           </ul>

           <ul>
               <div class="title">Раздел2</div>
               <li><a href=''>Пункт 1</a></li>
               <li><a href=''>Пункт 2</a></li>
               <li><a href=''>Пункт 3</a></li>
               <li><a href=''>Пункт 4</a></li>
           </ul>
       </div>
   </div>
    <div class='copyright'><div class='container'>Copyright by company 2016</div></div>
</div>
