const BASE_URL = "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies";

const dropdowns = document.querySelectorAll(".dropdown select");
const btn = document.querySelector("button");
const fromCurr = document.querySelector(".from select");
const toCurr = document.querySelector(".to select");
const msg = document.querySelector(".msg");
const slides = document.querySelector(".image_container");

let count = 0;

const scroll = () => {
    slides.forEach((slide) => {
        slide.style.transform = `translateX(-${(count * 100)}%)`;
    })
}



for(let select of dropdowns){
    for(code in countryList){
        let newOps = document.createElement("option");
        newOps.innerText = code;
        newOps.value = code;
        if(select.name === "from" && code == "INR"){
            newOps.selected = "selected";
        }
        else if(select.name === "to" && code == "USD"){
            newOps.selected = "selected";
        }

        select.append(newOps);
    }
    select.addEventListener("change", (evt) =>{
        UpdateFlag(evt.target);
    })
}

const UpdateFlag = (element) =>{
    let currCode = element.value;
    let countryCode = countryList[currCode];
    let newSrc = `https://flagsapi.com/${countryCode}/shiny/64.png`;
    let img = element.parentElement.querySelector("img");
    img.src = newSrc;
}

btn.addEventListener("click",  (evt) => {
    evt.preventDefault();
    updateExchangeRate();
})

const updateExchangeRate = async() =>{
    let amount = document.querySelector(".amount input");
    let amtval = amount.value;
    console.log(amtval);
    if(amtval < 1 || amtval === ""){
        amtval = 1;
        amount.value = "1";
    }
    const URL = `${BASE_URL}/${fromCurr.value.toLowerCase()}.json`;
    let response =  await fetch(URL);
    let data = await response.json();
    let rate = data[fromCurr.value.toLowerCase()][toCurr.value.toLowerCase()];
    console.log(rate);

    let finalAmount = amtval * rate;
    msg.innerText = `${amtval} ${fromCurr.value} = ${finalAmount} ${toCurr.value}`;
    if(fromCurr.value === toCurr.value){
        alert("You Have Entered the same country\n Change The options!!!\n");
        msg.innerText = "ENTER 2 DIFFERENT COUNTRIES";
    }

}

window.addEventListener("load", () =>{
    updateExchangeRate()
})