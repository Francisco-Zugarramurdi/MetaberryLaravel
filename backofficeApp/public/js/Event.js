var setNumber = 0;

document.getElementById("add-set-local").addEventListener('click',()=>{
    setNumber++;
    document.getElementById("setContainerLocal").innerHTML += `Set(${setNumber})<input type='number' name='setsLocal[]'>`;
});
document.getElementById("add-set-visitor").addEventListener('click',()=>{
    setNumber++;
    document.getElementById("setContainerVisitor").innerHTML += `Set(${setNumber})<input type='number' name='setsVisitant[]'>`;
});

function dropdown (container){

    const form = document.getElementById(container);

    if(form.classList.contains("hide")){
        form.classList.remove("hide");
        
    }
    else{
        form.classList.add("hide");
    }

}