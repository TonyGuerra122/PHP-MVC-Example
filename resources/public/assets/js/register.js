document.addEventListener('DOMContentLoaded', function(){

    document.getElementById('register-form').addEventListener('submit', async function(e){
        e.preventDefault();

        const data = {};

        for(const field of this.elements){

            data[field.name] = field.value;
        }

        const response = await fetch('register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })

        console.log(response.status)

    })

});