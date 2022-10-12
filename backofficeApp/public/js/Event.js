var setNumber = 0;
document.getElementById("button-set").addEventListener('click',()=>{
    const form = document.getElementById("sets");
    if(form.classList.contains("hide")){
        form.classList.remove("hide");
        
    }
    else{
        form.classList.add("hide");
    }
});
document.getElementById("add-set-local").addEventListener('click',()=>{
    setNumber++;
    document.getElementById("setContainerLocal").innerHTML += `Set(${setNumber})<input type='number' name='setsLocal[]'>`;
})
document.getElementById("add-set-visitant").addEventListener('click',()=>{
    setNumber++;
    document.getElementById("setContainerVisitant").innerHTML += `Set(${setNumber})<input type='number' name='setsVisitant[]'>`;
})


document.getElementById("button-points").addEventListener('click',()=>{
    const form = document.getElementById("points");
    if(form.classList.contains("hide")){
        form.classList.remove("hide");
        
    }
    else{
        form.classList.add("hide");
    }
});

document.getElementById("button-markUp").addEventListener('click',()=>{
    const form = document.getElementById("markUp");
    if(form.classList.contains("hide")){
        form.classList.remove("hide");
        
    }
    else{
        form.classList.add("hide");
    }
});
document.getElementById("button-markDown").addEventListener('click',()=>{
    const form = document.getElementById("markDown");
    if(form.classList.contains("hide")){
        form.classList.remove("hide");
        
    }
    else{
        form.classList.add("hide");
    }
});