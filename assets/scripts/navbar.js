
/* ------------------------------ Navbar menu burger 1 ------------------------------ */

const btnresponsive = document.querySelector(".hamburger");

const nav = document.querySelector(".s-trois");

const masque = document.querySelector(".mobile-masque");



btnresponsive.addEventListener("click", () => {


            nav.classList.toggle("hamburger-ouvert");
            masque.classList.toggle("mobile-masque-ouvert");


     });
        
            new ResizeObserver(entries => {
                if (entries[0].contentRect.width <= 900) {
                    nav.style.transition = "transform 0.3s ease-out"
                } else {
                    nav.style.transition = "none"
                }
            }).observe(document.body)
    
        
        





        const croixFermeture = document.querySelector(".mobile-fermeture");
        const navferme = document.querySelector(".s-trois");
        const masqueferme = document.querySelector(".mobile-masque");


          croixFermeture.addEventListener("click", () => {

            navferme.classList.remove("hamburger-ouvert");
            masqueferme.classList.remove("mobile-masque-ouvert");
            
            
        });



        