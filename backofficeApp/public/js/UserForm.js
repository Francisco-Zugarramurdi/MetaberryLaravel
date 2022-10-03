const form = document.getElementById("creationForm")
const name = document.getElementById('name')
const photo = document.getElementById('photo')
const email = document.getElementById('email')
const points = document.getElementById('points')
const totalPoints = document.getElementById('totalPoints')
const card = document.getElementById('card')
const password = document.getElementById('password')
const error = document.getElementById('error')



form.addEventListener("submit", (e) => {
  
  console.log("apreté submit!");
  let validated = validate()
  if(validated.length > 0){
    e.preventDefault();
    for(i=0; i<validated.length; i++){
      console.log(validated[i])
      error.innerHTML += `<p>${validated[i]}</p>` 
  }
  }
});

const validate = () =>{
    const cardRegex =/^4[0-9]{12}(?:[0-9]{3})?$/
    const passwordRegex =/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/
    const emailRegex=/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/
    const photoRegex=/[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/


    let error = []
    
    if(!cardRegex.test(card.value)){
        error.push("Wrong Credit Card")
    }

    if(!emailRegex.test(email.value)){
        error.push("Wrong email")
    }
    
    if(!photoRegex.test(photo.value)){
        error.push("Wrong photo's url")
    }
    
    if(!passwordRegex.test(password.value)){
      error.push("Wrong password, the password should has a capital letter, a number and a lenght higher than 8")
    }

    if(totalPoints<points){
        error.push("The total points cann't be higher than the current ones")
    }

    return error
}