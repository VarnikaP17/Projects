const count = document.querySelector(".count");
const btn = document.querySelector(".add");
const container = document.getElementById('container');
const input = document.getElementById("in");
const del = document.querySelector(".remove");
const check = document.querySelectorAll(".check");
const bar = document.querySelector('.bar');
const removeBar = document.getElementsByClassName('bar');
newBar = document.createElement('div');

let array = [];
total = 0;
let sum = 0;
let checked = 0;


document.addEventListener('DOMContentLoaded', () => {
    
    btn.addEventListener("click", () => {
        if(input.value != ''){
            total++;
            sum++;
            count.innerText = `${checked} / ${sum}`;
            const newElement = document.createElement('div');
            newElement.className = 'new';
            container.appendChild(newElement);
            val = 1;      
            addElement(newElement);
        }else{
            alert("Enter A Task!!");
        }
    })
    input.addEventListener('keypress', function(event){
        if(event.key === 'Enter'){
            event.preventDefault();
            if(input.value != ''){
                total++;
                sum++;
                count.innerText = `${checked} / ${sum}`;
                const newElement = document.createElement('div');
                newElement.className = 'new';
                container.appendChild(newElement);
                val = 1;      
                addElement(newElement);
            }else{
                alert("Enter A Task!!");
            }
        }
    })
    
})

function addElement(newElement){

    const child1 = document.createElement('div');
    child1.className = 'check';
    newElement.appendChild(child1);

    const child2 = document.createElement('div');
    child2.className = 'text';
    child2.innerText = input.value;
    input.value = '';
    newElement.appendChild(child2);
    
    const child3 = document.createElement('div');
    child3.className = 'remove';
    child3.innerHTML = '<i class="fa-regular fa-trash-can" style="color: #f02828;"></i>';
    newElement.appendChild(child3);
    let num = 0;

    child1.addEventListener('click', () => {
        if(num == 0){
            child2.style.color = "grey";
            child2.style.textDecoration = "line-through"; 
            child1.innerHTML = '<i class="fa-solid fa-check" style="color: #0c0d0d;"></i>';
            total--; 
            checked++;
            count.innerText = `${checked} / ${sum}`;
            newBar.style.width = `${((1/sum) * 300)}px`;
            num = 1;
            addBar();
            if(checked == sum && sum != 0){
                bar.style.backgroundColor = '#24feee';
                confetti();
                setTimeout(generateAlert, 2);
            }
        }
    });

    child3.addEventListener('click', () => {
        newElement.remove(); 
        if(checked == sum && sum != 0){
            newBar.style.width = '300px';
        }
        if(num != 1){
            total--; 
            sum--;
            newBar.style.width = `${((1/sum) * 300)}px`;
            count.innerText = `${checked} / ${sum}`; 
        }
        if(checked == sum && sum != 0){
            bar.style.backgroundColor = '#24feee';
            confetti();
            setTimeout(generateAlert, 2);
        }else{
            setTimeout(generateAlert2, 2); 
        }
        
    });
}

function generateAlert(){
    if(total == 0){
        setTimeout(() =>{
            alert("Hooray!!! Your Tasks Are Completed")},500);
        container.innerHTML = '';
        count.innerText = "0 / 0";
        checked = 0;
        sum = 0;
        bar.innerHTML = '';
        setTimeout(() =>{
            bar.style.backgroundColor = '#171c48';},400);
    } 
}

function generateAlert2(){
    if(total == 0){
        alert("You Don't Have any Task");
        container.innerHTML = '';
        count.innerText = "0 / 0";
        checked = 0;
        sum = 0;
        bar.innerHTML = '';
        bar.style.backgroundColor = '#171c48';
    } 
}

function addBar(){
    newBar = document.createElement('div');
    newBar.className = 'newBar';
    newBar.style.width = `${((1/sum) * 300)}px`;
    bar.appendChild(newBar);
}