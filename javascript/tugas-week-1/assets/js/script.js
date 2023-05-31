/** Data Lowongan */
const vacancies = [
    {
        lowongan_id: 1,
        lowongan_name: "Junior Programmer",
        positions: [
            {
                position_id: 1,
                position_name: "Junior Programmer - Bandung"
            },
            {
                position_id: 2,
                position_name: "Junior Programmer - Jakarta"
            }
        ]
    },
    {
        lowongan_id: 2,
        lowongan_name: "Senior Programmer",
        positions: [
            {
                position_id: 3,
                position_name: "Senior Programmer - Bandung"
            },
            {
                position_id: 4,
                position_name: "Senior Programmer - Jakarta"
            }
        ]
    },
    {
        lowongan_id: 3,
        lowongan_name: "System Administrator",
        positions: [
            {
                position_id: 5,
                position_name: "System Administrator - Bandung"
            },
            {
                position_id: 6,
                position_name: "System Administrator - Jakarta"
            }
        ]
    },
    {
        lowongan_id: 4,
        lowongan_name: "Mobile Developer",
        positions: [
            {
                position_id: 7,
                position_name: "Mobile Developer - Bandung"
            },
            {
                position_id: 8,
                position_name: "Mobile Developer - Jakarta"
            }
        ]
    },
];

/** Loop dan mapping lowongan */
const selectLowongan = document.getElementById("lowongan");

vacancies.forEach((value) => {
    let option = new Option(value.lowongan_name, value.lowongan_id)
    selectLowongan.append(option);
})

/** Loop dan mapping posisi */
const selectPosisi = document.getElementById("posisi");
selectLowongan.addEventListener("change", function () {
    // Reset dulu
    selectPosisi.innerHTML = ""
    selectPosisi.append(new Option("- Pilih Posisi -"))

    const { positions } = vacancies.find((value) => value.lowongan_id == this.value)
    positions.forEach((value) => {
        let option = new Option(value.position_name, value.position_id)
        selectPosisi.append(option);
    })

});

/** Action submit form receruitment */
document.getElementById("form-recruitment").onsubmit = (e) => {
    e.preventDefault()

    /** reset wrapper */
    document.querySelector(".wrapper-list-content").innerHTML = ""

    /** show modal */
    document.getElementById("modal-success-submit").classList.remove("hidden")

    /** Dapetin element nya */
    const elements = document.querySelectorAll('#form-recruitment input, #form-recruitment option:checked');
    elements.forEach((el) => {
        const clonedListWrapper = document.querySelector(".list-wrapper").cloneNode(true);
        clonedListWrapper.classList.remove("hidden")
        clonedListWrapper.querySelector(".list-title").textContent = el.nodeName != "OPTION" ? removeStar(el.parentElement.innerText) : getLabelOption(el)
        clonedListWrapper.querySelector(".list-content").textContent = el.nodeName != "OPTION" ? el.value : getTextContentOption(el.parentElement)
        document.querySelector(".wrapper-list-content").append(clonedListWrapper)
    })
}

function getTextContentOption(el) {
    return el.options[el.selectedIndex].textContent;
}

function getLabelOption(el) {
    const label = el.parentElement.previousElementSibling.textContent
    return removeStar(label)
}

function removeStar(text) {
    return text.replace("*", "")
}

/** Action kalau button close */
document.getElementById("close-modal").onclick = () => {
    /** reset form */
    document.getElementById("form-recruitment").reset()

    /** hide modal */
    document.getElementById("modal-success-submit").classList.add("hidden")
}