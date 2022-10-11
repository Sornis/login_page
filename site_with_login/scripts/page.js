



class ElementDisplayer {
    // expand this class to have a bunch of methods that manipulate elements, rename it 'ElementHandler'
    
    element;
    isDisplayed;

    constructor(element) {
        this.element = document.querySelector(element);
    }

    displayElement() {
        if (!this.isDisplayed) {
            this.element.style.display = "block";
            return this.isDisplayed = true;
        }
        this.element.style.display = "none";
        return this.isDisplayed = false;
    }
}

const background = document.querySelector("body");
const headline = document.querySelector("#headline");
const textContent = document.querySelector("#textContent");
const imageButton = document.querySelector("img");
const editButton = document.querySelector("#editButton");
const headlineInput = document.querySelector("#headlineInput");
const textInput = document.querySelector("#textInput");
const colourSelect = document.querySelector("#colourSelect");
const submit = document.querySelector("#submitButton");
const email = document.querySelector("#email");
const username = document.querySelector("#username");
const exitEdit = document.querySelector("#exitImage");

const loginBtn = document.querySelector("#loginBtn");
const loginWindow = document.querySelector("#loginWindow");

const signupBtn = document.querySelector("#signupBtn");
const signupWindow = document.querySelector("#signupWindow");

const elements = {
    imageButton: document.querySelector("img"),
    editButton: document.querySelector("#editButton")
};

var menu = new ElementDisplayer('#userMenu');
var options = new ElementDisplayer('#userOptions');
let login = new ElementDisplayer('#loginWindow');
let signup = new ElementDisplayer('#signupWindow');

loginBtn.addEventListener("click", () => {
    login.displayElement();
})

signupBtn.addEventListener("click", () => {
    signup.displayElement();
})

imageButton.addEventListener("click", () => {

    // opens the menu
    menu.displayElement();
});
editButton.addEventListener("click", () => {

    // closes the menu
    menu.displayElement();

    // opens the interface for editing the page if it's not already open 
    if (options.isDisplayed) {
        options.element.style.display = "block"; 
        options.isDisplayed = true;
    }
    else options.displayElement();
});

exitEdit.addEventListener("click", () => {
    options.displayElement();
});

