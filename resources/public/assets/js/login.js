document.addEventListener('DOMContentLoaded', function(){

    document.getElementById('login-form').addEventListener('submit', function(e){
        e.preventDefault();

        const data = {};

        for(const field of this.elements){
            if(field.name){
                data[field.name] = field.value;
            }
        }

        console.log(data);

    });

})