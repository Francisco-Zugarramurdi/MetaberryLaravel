var setNumberVisitor = 0;
var setNumberLocal = 0;

document.getElementById("add-set").addEventListener('click',()=>{
    setNumberLocal++;
    document.getElementById("setContainerLocal").innerHTML += `<p>Set(${setNumberLocal})</p><input type='number' name='setsLocal[]'>`;
    setNumberVisitor++;
    document.getElementById("setContainerVisitor").innerHTML += `<p style="fontSize=.8em;">Set(${setNumberVisitor})</p><input type='number' name='setsVisitor[]'>`;
});

function dropdown (container){

    const form = document.getElementById(container);
    const icon_show = document.getElementById('show_icon_'+container);
    const icon_hide = document.getElementById('hide_icon_'+container);

    if(!form.classList.contains("hide")){
        form.classList.add("hide");
        icon_show.classList.remove("hidden");
        icon_hide.classList.add("hidden");
        
    }
    else{
        form.classList.remove("hide");
        icon_show.classList.add("hidden");
        icon_hide.classList.remove("hidden");
    }

}