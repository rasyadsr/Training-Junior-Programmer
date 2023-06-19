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
        ],
        available_quota: 1
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
        ],
        available_quota: 2
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
        ],
        available_quota: 3
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
        ],
        available_quota: 4
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
    let disabledOption = new Option("- Pilih Posisi -")
    disabledOption.disabled = true
    selectPosisi.append(disabledOption)

    const { positions } = vacancies.find((value) => value.lowongan_id == this.value)
    positions.forEach((value) => {
        let option = new Option(value.position_name, value.position_id)
        selectPosisi.append(option);
    })

});

/** Action submit form receruitment */
document.getElementById("form-recruitment").onsubmit = (e) => {
    e.preventDefault()

    /** Dapetin element nya */
    const elements = document.querySelectorAll('#form-recruitment input, #form-recruitment option:checked');

    /** Validasi mandatory */
    if (Array.from(elements).some((el) => el.value == "")) {
        alert('Semua input wajib di isi')
        return
    }

    /** Validasi email sudah digunakan atau belum */
    const elInputEmail = document.getElementById("email");
    if (findApplicantByEmail(elInputEmail.value)) {
        alert("Email tersebut sudah digunakan")
        return
    }

    const elOptionLowongan = document.getElementById("lowongan");

    /** Validasi Quota ada atau tidak */
    if (!checkVacanciesQuotaIsAvailable(elOptionLowongan.value)) {
        alert(`Mohon maaf, rekrutasi untuk ${getTextContentOption(elOptionLowongan)} sudah penuh. dan tidak dapat dipilih`)
        return
    }

    /** Informasi Quota <= 2  */
    if (checkQuotaIsLessThanOrEqualTwo(elOptionLowongan.value)) {
        alert(`Kuota tersisa untuk ${getTextContentOption(elOptionLowongan)} hanya 2 pendaftar.`)
    }

    /** Informasi dapat memilih lowongan */
    alert(`Anda dapat memilih lowongan ${getTextContentOption(elOptionLowongan)}`)

    /** reset wrapper */
    document.querySelector(".wrapper-list-content").innerHTML = ""

    /** show modal */
    document.getElementById("modal-success-submit").classList.remove("hidden")

    let tempApplicant = {}

    /** Mapping ke card */
    elements.forEach((el) => {
        const clonedListWrapper = document.querySelector(".list-wrapper").cloneNode(true);
        clonedListWrapper.classList.remove("hidden")

        /** Set each title card */
        const title = el.nodeName != "OPTION" ? removeStar(el.parentElement.innerText) : getLabelOption(el)
        clonedListWrapper.querySelector(".list-title").textContent = title

        /** Set each value card */
        const content = el.nodeName != "OPTION" ? el.value : getTextContentOption(el.parentElement)
        clonedListWrapper.querySelector(".list-content").textContent = content

        /** Append to card */
        document.querySelector(".wrapper-list-content").append(clonedListWrapper)

        /** Push ke tempApplicant */
        tempApplicant[title.toLowerCase().trim()] = content
    })

    applicants.push(tempApplicant)

    /** 
     * Menampilkan informasi jumlah orang yang telah melakukan lamaran 
     * ke posisi tersebut
     * */
    document.querySelector('.info-lowongan').innerHTML = ""

    const pElInfoPelamar = document.createElement("p")
    pElInfoPelamar.textContent = `Jumlah pelamar yang telah melakukan apply ke lowongan ${getTextContentOption(elOptionLowongan)}`

    const pElCountPelamar = document.createElement("p")
    pElCountPelamar.textContent = `Adalah ${countApplicantWhoApplied(elOptionLowongan.value)} Orang`;

    document.querySelector('.info-lowongan').append(pElInfoPelamar, pElCountPelamar)

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

/** Data Pelamar */
const applicants = []

function findApplicantByEmail(email) {
    return applicants.find((applicant) => applicant.email === email)
}

function checkVacanciesQuotaIsAvailable(lowongan_id) {
    const selectedVacancy = vacancies.find(vacancy => vacancy.lowongan_id == lowongan_id)

    const applicantWhoSelectThatVacancy = applicants.filter(applicant => applicant.lowongan == selectedVacancy.lowongan_name)

    return applicantWhoSelectThatVacancy.length !== selectedVacancy.available_quota;
}

function checkQuotaIsLessThanOrEqualTwo(lowongan_id) {
    const selectedVacancy = vacancies.find(vacancy => vacancy.lowongan_id == lowongan_id)
    const applicantWhoSelectThatVacancy = applicants.filter(applicant => applicant.lowongan == selectedVacancy.lowongan_name)
    return selectedVacancy.available_quota - applicantWhoSelectThatVacancy.length <= 2
}

function countApplicantWhoApplied(lowongan_id) {
    const selectedVacancy = vacancies.find(vacancy => vacancy.lowongan_id == lowongan_id)
    const applicantWhoSelectThatVacancy = applicants.filter(applicant => applicant.lowongan == selectedVacancy.lowongan_name)

    return applicantWhoSelectThatVacancy.length
}