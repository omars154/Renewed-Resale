document.addEventListener('DOMContentLoaded',function(){
    let password=document.getElementById('password')
    let rePassword=document.getElementById('rePassword')
    let submit=document.getElementById('submit')

    submit.addEventListener('click',function(event){
        if (password.value!=rePassword.value)
        {
            alert('Passwords do not match');
            event.preventDefault();
        }
    });
});
