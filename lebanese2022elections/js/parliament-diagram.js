const mps = document.getElementsByClassName('MP');

let nextLine = 0;

let r = 200;

let xOffeset = 55;
let thetaOffset = Math.PI/2;

let theta = 0-thetaOffset;


let mpPerLine = 5;

Array.from(mps).forEach(mp => {
    if(nextLine > mpPerLine-1)
    {
        nextLine = 0;

        console.log("pipieopfjsf");
        theta += (Math.PI + 2*thetaOffset)/(Math.round(128/mpPerLine));
    }

    mp.style.bottom = (r + nextLine*xOffeset)*Math.sin(Math.PI - theta) + 'px';
    mp.style.left = (r + nextLine*xOffeset)*Math.cos(Math.PI - theta) + 'px';

    nextLine++;    
});