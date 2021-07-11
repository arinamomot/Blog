const like= document.getElementById('like');
const likes= document.getElementById('likes');
const id=document.location.search.split("=")[1];

like.addEventListener("click", addlike);

async function addlike() {
    let result =await fetch("/~momotari/sem/like.php?id="+id);
    result = await result.text();
    if (result[0] === "t") {
        console.log(1);
        likes.innerText = Number(likes.innerText)+1;
        like.style.color= "red" ;
    }
}
