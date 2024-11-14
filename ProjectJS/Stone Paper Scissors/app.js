let userScore = 0;
let compScore = 0;

const choices = document.querySelectorAll(".choice");
const msg = document.querySelector("#message");
const u = document.querySelector("#userScore");
const c = document.querySelector("#compScore");
const re = document.querySelector("#restart");

const getCompChoice = () => {
    const ops = ["rock", "paper", "scissors"];
    const rand = Math.floor(Math.random() * 3);
    return ops[rand];
}

const score = () => {
    u.innerText = userScore;
    c.innerText = compScore;
}

const drawGame = () =>{
    console.log("Game was draw");
    msg.innerText = "Game Was a Draw"
    msg.style.backgroundColor = "#081b31";
}

const clicked = () =>{
        compScore = 0;
        userScore = 0;
        u.innerText = userScore;
        c.innerText = compScore;
        msg.innerText = "Play your move";
        msg.style.backgroundColor = "#081b31"
}


const showWinner = (userWin, userChoice, compChoice) =>{
    if(userWin === true){
        userScore++;
        console.log(`You Win!, your ${userChoice} beats ${compChoice}`);
        msg.innerText = `You Win!, your ${userChoice} beats ${compChoice}`;
        msg.style.backgroundColor = "green";
    }
    else{
        compScore++;
        console.log(`You lose, your ${userChoice} lost to ${compChoice}`);
        msg.innerText = `You lose, your ${userChoice} lost to ${compChoice}`;
        msg.style.backgroundColor = "red";
    }
}

const playgame = (userChoice) =>  {
    console.log("userChoice = ", userChoice);
    const compChoice = getCompChoice();
    console.log("compChoice = ", compChoice);
    if(userChoice === compChoice){
        drawGame();
    }
    else{
        let userWin = true;
        if(userChoice === "rock"){
            if(compChoice === "paper"){
                userWin = false;
            }
        }
        else if(userChoice === "paper"){
            if(compChoice === "scissors"){
                userWin = false;
            }
        }
        else if(userChoice === "scissors"){
            if(compChoice === "rock"){
                userWin = false;
            }
        }
        showWinner(userWin, userChoice, compChoice);
        score();
    }
}

choices.forEach((choice) => {
    console.log(choice);
    choice.addEventListener("click", () => {
        const userChoice = choice.getAttribute("id");
        playgame(userChoice);
    })
})