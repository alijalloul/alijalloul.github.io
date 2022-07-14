Array.from(mps).forEach(mp => {
    mp.addEventListener("click", () => {
        if(document.getElementsByClassName('card-wrapper').length)
        {
            document.getElementsByClassName('card-wrapper')[0].remove();
        }
        console.log("dvfsdlfhvsuivhsiovhsdvh");

        let card_wrapper = document.createElement('div');
        card_wrapper.classList.add("card-wrapper");
        document.body.appendChild(card_wrapper);

            let card = document.createElement('div');
            card.classList.add("card");
            card_wrapper.appendChild(card);

                let card_left = document.createElement('div');
                card_left.classList.add("card-left");
                card.appendChild(card_left);

                    let card_img = document.createElement('img');
                    card_img.src = mp.attributes.imgsrc.textContent;
                    card_left.appendChild(card_img);

                let card_right = document.createElement('div');
                card_right.classList.add("card-right");
                card.appendChild(card_right);

                    let mpName = document.createElement('div');
                    mpName.classList.add("mpInfo", "mpName");
                    card_right.appendChild(mpName);

                        let name = document.createElement('h3');
                        name.innerHTML = "Name: ";
                        mpName.appendChild(name);

                        let name2 = document.createElement('h4');
                        name2.innerHTML = mp.attributes.name.textContent;
                        mpName.appendChild(name2);

                    card_right.appendChild(document.createElement('hr'));
                    let mpReligion = document.createElement('div');
                    mpReligion.classList.add("mpInfo", "mpVotes");
                    card_right.appendChild(mpReligion);

                        let religion = document.createElement('h3');
                        religion.innerHTML = "Religion: ";
                        mpReligion.appendChild(religion);

                        let religion2 = document.createElement('h4');
                        religion2.innerHTML = mp.attributes.religion.textContent;
                        mpReligion.appendChild(religion2);

                    card_right.appendChild(document.createElement('hr'));
                    let mpDistrict = document.createElement('div');
                    mpDistrict.classList.add("mpInfo", "mpDistrict");
                    card_right.appendChild(mpDistrict);

                        let district = document.createElement('h3');
                        district.innerHTML = "District: ";
                        mpDistrict.appendChild(district);

                        let district2 = document.createElement('h4');
                        district2.innerHTML = mp.attributes.district.textContent;
                        mpDistrict.appendChild(district2);

                    card_right.appendChild(document.createElement('hr'));
                    let mpVotes = document.createElement('div');
                    mpVotes.classList.add("mpInfo", "mpVotes");
                    card_right.appendChild(mpVotes);

                        let votes = document.createElement('h3');
                        votes.innerHTML = "Votes: ";
                        mpVotes.appendChild(votes);

                        let votes2 = document.createElement('h4');
                        votes2.innerHTML = mp.attributes.votes.textContent;
                        mpVotes.appendChild(votes2);



                

    });
});