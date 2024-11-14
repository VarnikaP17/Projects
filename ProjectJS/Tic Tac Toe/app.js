let boxes = document.querySelectorAll(".box");
let reset = document.querySelector("#reset");
let newBtn = document.querySelector("#new");
let msgContainer = document.querySelector(".msg-container");
let msg = document.querySelector("#msg");

let count = 0;
let num = true;
let turnO = true;

let winpatterns = [
    [0, 1, 2],
    [0, 3, 6],
    [0, 4, 8],
    [1, 4, 7],
    [2, 5, 8],
    [2, 4, 6],
    [3, 4, 5],
    [6, 7, 8],
];

const resetGame = () =>{
    turnO = true;
    num = true;
    count = 0;
    enablebox();
}

const disablebox = () =>{
    for(let box of boxes){
        box.disabled = true;
    }
}

const enablebox = () =>{
    for(let box of boxes){
        box.disabled = false;
        box.innerText = ""; 
        msgContainer.classList.add("hide");
    }
}

boxes.forEach((box) => {
    box.addEventListener("click", () => {
        console.log("box was clicked");
        count++;
        if(turnO){
            box.innerText = "O";
            turnO = false;
        }else{
            box.innerText = "X";
            turnO = true;
        }
        box.disabled = true;
        checkWinner();
    })
    
})

const showWinner = (winner) => {
    msg.innerText = `Congratulations, The Winner is ${winner}`;
    msgContainer.classList.remove("hide");
    disablebox();
}

const checkWinner = () => {
    for(let pattern of winpatterns){
        let pos1Val = boxes[pattern[0]].innerText; 
        let pos2Val = boxes[pattern[1]].innerText; 
        let pos3Val = boxes[pattern[2]].innerText; 

        if(pos1Val != "" && pos2Val != "" && pos3Val != ""){
            if(pos1Val === pos2Val && pos2Val === pos3Val){
                console.log(`The winner is ${pos1Val}`);
                num = false;
                count = 0;
                showWinner(pos1Val);
            }
        }
    }
    if(num == true && count === 9){
        msg.innerText = "The Game is a draw";
        count = 0;
        msgContainer.classList.remove("hide");
        disablebox();
    }
}

newBtn.addEventListener("click", resetGame);
reset.addEventListener("click", resetGame)