const toShowIcon = document.getElementById('show_icon')
const toHideIcon = document.getElementById('hide_icon')
const createUserContainer = document.getElementById('create_user_container')

const dropdown = () => {

    if(createUserContainer.classList.contains("hide")){

        createUserContainer.classList.remove("hide")
        toShowIcon.classList.remove("hidden")
        toHideIcon.classList.add("hidden")

    } else {

        createUserContainer.classList.add("hide")
        toShowIcon.classList.add("hidden")
        toHideIcon.classList.remove("hidden")

    }

}