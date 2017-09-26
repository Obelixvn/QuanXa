<html>

    <script>
        function change_date(){
            
            var i = document.getElementsByName('test');
             
            alert(i[0].value);
        }
            
    </script>

    <input type = "text" name ="test" value ="lost"/>
     <input type = "text" name ="test" value ="dont"/>
    <button onclick = "change_date()"></button>
    </html>