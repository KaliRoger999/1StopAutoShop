const vehicleData = {
  2025: {
    "Honda": ["Civic", "Accord", "CR-V", "Pilot", "HR-V", "Passport", "Ridgeline", "Odyssey"],
    "Toyota": ["Corolla", "Camry", "RAV4", "Highlander", "Prius", "4Runner", "Tacoma", "Tundra", "Sienna", "Avalon", "Venza", "C-HR"],
    "Ford": ["F-150", "Mustang", "Explorer", "Escape", "Edge", "Expedition", "Ranger", "Bronco", "Bronco Sport", "Maverick"],
    "Chevrolet": ["Silverado", "Equinox", "Malibu", "Tahoe", "Camaro", "Traverse", "Suburban", "Colorado", "Blazer", "Trax"],
    "Nissan": ["Altima", "Sentra", "Rogue", "Pathfinder", "Versa", "Murano", "Armada", "Frontier", "Kicks", "Ariya"],
    "BMW": ["3 Series", "5 Series", "X3", "X5", "X1", "X7", "4 Series", "7 Series", "Z4", "iX", "i4", "X6", "2 Series"],
    "Mercedes-Benz": ["C-Class", "E-Class", "GLC", "GLE", "A-Class", "S-Class", "GLA", "GLB", "GLS", "CLA", "G-Class", "EQS", "EQE"],
    "Audi": ["A3", "A4", "Q3", "Q5", "A6", "Q7", "A8", "Q8", "e-tron", "A5", "TT", "R8"],
    "Ferrari": ["SF90 Stradale", "F8 Tributo", "Roma", "Portofino M", "812 Superfast", "296 GTB", "Purosangue"],
    "Porsche": ["911", "Cayenne", "Macan", "Panamera", "Taycan", "718 Cayman", "718 Boxster"],
    "Alfa Romeo": ["Giulia", "Stelvio", "Tonale", "4C"],
    "Lamborghini": ["Huracán", "Aventador", "Urus", "Revuelto"],
    "McLaren": ["720S", "Artura", "GT", "765LT"],
    "Maserati": ["Ghibli", "Levante", "Quattroporte", "MC20", "Grecale"],
    "Lexus": ["ES", "RX", "NX", "IS", "GX", "LX", "UX", "LS", "LC", "RC"],
    "Acura": ["TLX", "MDX", "RDX", "ILX", "NSX", "TLX Type S"],
    "Infiniti": ["Q50", "QX60", "QX80", "Q60", "QX50"],
    "Cadillac": ["Escalade", "XT5", "CT5", "XT6", "CT4", "Lyriq"],
    "Lincoln": ["Navigator", "Aviator", "Corsair", "Continental"],
    "Genesis": ["G90", "GV80", "G80", "GV70", "G70"],
    "Volvo": ["XC90", "XC60", "S60", "V60", "XC40", "S90", "V90"],
    "Jaguar": ["F-PACE", "XF", "F-TYPE", "E-PACE", "I-PACE"],
    "Land Rover": ["Range Rover", "Discovery", "Defender", "Range Rover Sport", "Range Rover Evoque", "Discovery Sport"]
  },
  2024: {
    "Honda": ["Civic", "Accord", "CR-V", "Pilot", "HR-V", "Passport", "Ridgeline", "Odyssey"],
    "Toyota": ["Corolla", "Camry", "RAV4", "Highlander", "Prius", "4Runner", "Tacoma", "Tundra", "Sienna", "Avalon", "Venza", "C-HR"],
    "Ford": ["F-150", "Mustang", "Explorer", "Escape", "Edge", "Expedition", "Ranger", "Bronco", "Bronco Sport", "Maverick"],
    "Chevrolet": ["Silverado", "Equinox", "Malibu", "Tahoe", "Camaro", "Traverse", "Suburban", "Colorado", "Blazer", "Trax"],
    "Nissan": ["Altima", "Sentra", "Rogue", "Pathfinder", "Versa", "Murano", "Armada", "Frontier", "Kicks", "Ariya"],
    "BMW": ["3 Series", "5 Series", "X3", "X5", "X1", "X7", "4 Series", "7 Series", "Z4", "iX", "i4", "X6", "2 Series"],
    "Mercedes-Benz": ["C-Class", "E-Class", "GLC", "GLE", "A-Class", "S-Class", "GLA", "GLB", "GLS", "CLA", "G-Class", "EQS", "EQE"],
    "Audi": ["A3", "A4", "Q3", "Q5", "A6", "Q7", "A8", "Q8", "e-tron", "A5", "TT", "R8"],
    "Ferrari": ["SF90 Stradale", "F8 Tributo", "Roma", "Portofino M", "812 Superfast", "296 GTB", "Purosangue"],
    "Porsche": ["911", "Cayenne", "Macan", "Panamera", "Taycan", "718 Cayman", "718 Boxster"],
    "Alfa Romeo": ["Giulia", "Stelvio", "Tonale"],
    "Lamborghini": ["Huracán", "Aventador", "Urus", "Revuelto"],
    "McLaren": ["720S", "Artura", "GT", "765LT"],
    "Maserati": ["Ghibli", "Levante", "Quattroporte", "MC20", "Grecale"],
    "Lexus": ["ES", "RX", "NX", "IS", "GX", "LX", "UX", "LS", "LC", "RC"],
    "Acura": ["TLX", "MDX", "RDX", "ILX", "NSX", "TLX Type S"],
    "Infiniti": ["Q50", "QX60", "QX80", "Q60", "QX50"],
    "Cadillac": ["Escalade", "XT5", "CT5", "XT6", "CT4", "Lyriq"],
    "Lincoln": ["Navigator", "Aviator", "Corsair", "Continental"],
    "Genesis": ["G90", "GV80", "G80", "GV70", "G70"],
    "Volvo": ["XC90", "XC60", "S60", "V60", "XC40", "S90", "V90"],
    "Jaguar": ["F-PACE", "XF", "F-TYPE", "E-PACE", "I-PACE"],
    "Land Rover": ["Range Rover", "Discovery", "Defender", "Range Rover Sport", "Range Rover Evoque", "Discovery Sport"]
  },
  2023: {
    "Honda": ["Civic", "Accord", "CR-V", "Pilot", "HR-V", "Passport", "Ridgeline", "Odyssey"],
    "Toyota": ["Corolla", "Camry", "RAV4", "Highlander", "Prius", "4Runner", "Tacoma", "Tundra", "Sienna", "Avalon", "Venza", "C-HR"],
    "Ford": ["F-150", "Mustang", "Explorer", "Escape", "Edge", "Expedition", "Ranger", "Bronco", "Bronco Sport", "Maverick"],
    "Chevrolet": ["Silverado", "Equinox", "Malibu", "Tahoe", "Camaro", "Traverse", "Suburban", "Colorado", "Blazer", "Trax"],
    "Nissan": ["Altima", "Sentra", "Rogue", "Pathfinder", "Versa", "Murano", "Armada", "Frontier", "Kicks", "Ariya"],
    "BMW": ["3 Series", "5 Series", "X3", "X5", "X1", "X7", "4 Series", "7 Series", "Z4", "iX", "i4", "X6", "2 Series"],
    "Mercedes-Benz": ["C-Class", "E-Class", "GLC", "GLE", "A-Class", "S-Class", "GLA", "GLB", "GLS", "CLA", "G-Class", "EQS", "EQE"],
    "Audi": ["A3", "A4", "Q3", "Q5", "A6", "Q7", "A8", "Q8", "e-tron", "A5", "TT", "R8"],
    "Ferrari": ["SF90 Stradale", "F8 Tributo", "Roma", "Portofino M", "812 Superfast", "296 GTB"],
    "Porsche": ["911", "Cayenne", "Macan", "Panamera", "Taycan", "718 Cayman", "718 Boxster"],
    "Alfa Romeo": ["Giulia", "Stelvio", "Tonale"],
    "Lamborghini": ["Huracán", "Aventador", "Urus"],
    "McLaren": ["720S", "Artura", "GT", "765LT"],
    "Maserati": ["Ghibli", "Levante", "Quattroporte", "MC20", "Grecale"],
    "Lexus": ["ES", "RX", "NX", "IS", "GX", "LX", "UX", "LS", "LC", "RC"],
    "Acura": ["TLX", "MDX", "RDX", "ILX", "NSX"],
    "Infiniti": ["Q50", "QX60", "QX80", "Q60", "QX50"],
    "Cadillac": ["Escalade", "XT5", "CT5", "XT6", "CT4", "Lyriq"],
    "Lincoln": ["Navigator", "Aviator", "Corsair", "Continental"],
    "Genesis": ["G90", "GV80", "G80", "GV70", "G70"],
    "Volvo": ["XC90", "XC60", "S60", "V60", "XC40", "S90", "V90"],
    "Jaguar": ["F-PACE", "XF", "F-TYPE", "E-PACE", "I-PACE"],
    "Land Rover": ["Range Rover", "Discovery", "Defender", "Range Rover Sport", "Range Rover Evoque", "Discovery Sport"]
  },
  2022: {
    "Honda": ["Civic", "Accord", "CR-V", "Pilot", "HR-V", "Passport", "Ridgeline", "Odyssey", "Fit"],
    "Toyota": ["Corolla", "Camry", "RAV4", "Highlander", "Prius", "4Runner", "Tacoma", "Tundra", "Sienna", "Avalon", "Venza", "C-HR"],
    "Ford": ["F-150", "Mustang", "Explorer", "Escape", "Edge", "Expedition", "Ranger", "Bronco", "Bronco Sport", "Maverick"],
    "Chevrolet": ["Silverado", "Equinox", "Malibu", "Tahoe", "Camaro", "Traverse", "Suburban", "Colorado", "Blazer", "Trax"],
    "Nissan": ["Altima", "Sentra", "Rogue", "Pathfinder", "Versa", "Murano", "Armada", "Frontier", "Kicks"],
    "BMW": ["3 Series", "5 Series", "X3", "X5", "X1", "X7", "4 Series", "7 Series", "Z4", "iX", "i4", "X6", "2 Series"],
    "Mercedes-Benz": ["C-Class", "E-Class", "GLC", "GLE", "A-Class", "S-Class", "GLA", "GLB", "GLS", "CLA", "G-Class", "EQS"],
    "Audi": ["A3", "A4", "Q3", "Q5", "A6", "Q7", "A8", "Q8", "e-tron GT", "A5", "TT", "R8"],
    "Ferrari": ["SF90 Stradale", "F8 Tributo", "Roma", "Portofino M", "812 Superfast", "296 GTB"],
    "Porsche": ["911", "Cayenne", "Macan", "Panamera", "Taycan", "718 Cayman", "718 Boxster"],
    "Alfa Romeo": ["Giulia", "Stelvio"],
    "Lamborghini": ["Huracán", "Aventador", "Urus"],
    "McLaren": ["720S", "Artura", "GT", "765LT"],
    "Maserati": ["Ghibli", "Levante", "Quattroporte", "MC20"],
    "Lexus": ["ES", "RX", "NX", "IS", "GX", "LX", "UX", "LS", "LC", "RC"],
    "Acura": ["TLX", "MDX", "RDX", "ILX", "NSX"],
    "Infiniti": ["Q50", "QX60", "QX80", "Q60", "QX50"],
    "Cadillac": ["Escalade", "XT5", "CT5", "XT6", "CT4"],
    "Lincoln": ["Navigator", "Aviator", "Corsair", "Continental"],
    "Genesis": ["G90", "GV80", "G80", "GV70", "G70"],
    "Volvo": ["XC90", "XC60", "S60", "V60", "XC40", "S90", "V90"],
    "Jaguar": ["F-PACE", "XF", "F-TYPE", "E-PACE", "I-PACE"],
    "Land Rover": ["Range Rover", "Discovery", "Defender", "Range Rover Sport", "Range Rover Evoque", "Discovery Sport"]
  },
  2021: {
    "Honda": ["Civic", "Accord", "CR-V", "Pilot", "HR-V", "Passport", "Ridgeline", "Odyssey", "Fit", "Insight"],
    "Toyota": ["Corolla", "Camry", "RAV4", "Highlander", "Prius", "4Runner", "Tacoma", "Tundra", "Sienna", "Avalon", "Venza", "C-HR"],
    "Ford": ["F-150", "Mustang", "Explorer", "Escape", "Edge", "Expedition", "Ranger", "Bronco", "Bronco Sport", "EcoSport"],
    "Chevrolet": ["Silverado", "Equinox", "Malibu", "Tahoe", "Camaro", "Traverse", "Suburban", "Colorado", "Blazer", "Trax", "Spark"],
    "Nissan": ["Altima", "Sentra", "Rogue", "Pathfinder", "Versa", "Murano", "Armada", "Frontier", "Kicks", "Maxima"],
    "BMW": ["3 Series", "5 Series", "X3", "X5", "X1", "X7", "4 Series", "7 Series", "Z4", "i3", "X6", "2 Series"],
    "Mercedes-Benz": ["C-Class", "E-Class", "GLC", "GLE", "A-Class", "S-Class", "GLA", "GLB", "GLS", "CLA", "G-Class"],
    "Audi": ["A3", "A4", "Q3", "Q5", "A6", "Q7", "A8", "Q8", "e-tron GT", "A5", "TT", "R8"],
    "Ferrari": ["SF90 Stradale", "F8 Tributo", "Roma", "Portofino", "812 Superfast"],
    "Porsche": ["911", "Cayenne", "Macan", "Panamera", "Taycan", "718 Cayman", "718 Boxster"],
    "Alfa Romeo": ["Giulia", "Stelvio", "4C"],
    "Lamborghini": ["Huracán", "Aventador", "Urus"],
    "McLaren": ["720S", "GT", "765LT", "570S"],
    "Maserati": ["Ghibli", "Levante", "Quattroporte"],
    "Lexus": ["ES", "RX", "NX", "IS", "GX", "LX", "UX", "LS", "LC", "RC"],
    "Acura": ["TLX", "MDX", "RDX", "ILX", "NSX"],
    "Infiniti": ["Q50", "QX60", "QX80", "Q60", "QX50"],
    "Cadillac": ["Escalade", "XT5", "CT5", "XT6", "CT4"],
    "Lincoln": ["Navigator", "Aviator", "Corsair", "Continental"],
    "Genesis": ["G90", "GV80", "G80", "GV70", "G70"],
    "Volvo": ["XC90", "XC60", "S60", "V60", "XC40", "S90", "V90"],
    "Jaguar": ["F-PACE", "XF", "F-TYPE", "E-PACE", "I-PACE"],
    "Land Rover": ["Range Rover", "Discovery", "Defender", "Range Rover Sport", "Range Rover Evoque", "Discovery Sport"]
  },
  2020: {
    "Honda": ["Civic", "Accord", "CR-V", "Pilot", "HR-V", "Passport", "Ridgeline", "Odyssey", "Fit", "Insight"],
    "Toyota": ["Corolla", "Camry", "RAV4", "Highlander", "Prius", "4Runner", "Tacoma", "Tundra", "Sienna", "Avalon", "C-HR"],
    "Ford": ["F-150", "Mustang", "Explorer", "Escape", "Edge", "Expedition", "Ranger", "EcoSport", "Fusion"],
    "Chevrolet": ["Silverado", "Equinox", "Malibu", "Tahoe", "Camaro", "Traverse", "Suburban", "Colorado", "Blazer", "Trax", "Spark", "Impala"],
    "Nissan": ["Altima", "Sentra", "Rogue", "Pathfinder", "Versa", "Murano", "Armada", "Frontier", "Kicks", "Maxima", "370Z"],
    "BMW": ["3 Series", "5 Series", "X3", "X5", "X1", "X7", "4 Series", "7 Series", "Z4", "i3", "X6", "2 Series"],
    "Mercedes-Benz": ["C-Class", "E-Class", "GLC", "GLE", "A-Class", "S-Class", "GLA", "GLB", "GLS", "CLA", "G-Class"],
    "Audi": ["A3", "A4", "Q3", "Q5", "A6", "Q7", "A8", "Q8", "A5", "TT", "R8"],
    "Ferrari": ["812 Superfast", "Portofino", "F8 Tributo", "SF90 Stradale"],
    "Porsche": ["911", "Cayenne", "Macan", "Panamera", "Taycan", "718 Cayman", "718 Boxster"],
    "Alfa Romeo": ["Giulia", "Stelvio", "4C"],
    "Lamborghini": ["Huracán", "Aventador", "Urus"],
    "McLaren": ["720S", "GT", "570S", "600LT"],
    "Maserati": ["Ghibli", "Levante", "Quattroporte"],
    "Lexus": ["ES", "RX", "NX", "IS", "GX", "LX", "UX", "LS", "LC", "RC"],
    "Acura": ["TLX", "MDX", "RDX", "ILX", "NSX"],
    "Infiniti": ["Q50", "QX60", "QX80", "Q60", "QX50"],
    "Cadillac": ["Escalade", "XT5", "CT6", "XT6", "CT5", "CT4"],
    "Lincoln": ["Navigator", "Aviator", "Corsair", "Continental", "MKZ"],
    "Genesis": ["G90", "G80", "G70"],
    "Volvo": ["XC90", "XC60", "S60", "V60", "XC40", "S90", "V90"],
    "Jaguar": ["F-PACE", "XF", "F-TYPE", "E-PACE", "I-PACE", "XE"],
    "Land Rover": ["Range Rover", "Discovery", "Range Rover Sport", "Range Rover Evoque", "Discovery Sport"]
  }
};

document.addEventListener('DOMContentLoaded', function() {
    populateYears();
    loadSavedVehicle();
});

function populateYears() {
    const yearSelect = document.getElementById('year-select');
    const currentYear = new Date().getFullYear();
    
    for (let year = currentYear; year >= 1990; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }
}

function updateMakes() {
    const yearSelect = document.getElementById('year-select');
    const makeSelect = document.getElementById('make-select');
    const modelSelect = document.getElementById('model-select');
    
    const selectedYear = yearSelect.value;
    
    makeSelect.innerHTML = '<option value="">Select Make</option>';
    modelSelect.innerHTML = '<option value="">Select Model</option>';
    modelSelect.disabled = true;
    
    if (selectedYear && vehicleData[selectedYear]) {
        makeSelect.disabled = false;
        const makes = Object.keys(vehicleData[selectedYear]);
        
        makes.forEach(make => {
            const option = document.createElement('option');
            option.value = make;
            option.textContent = make;
            makeSelect.appendChild(option);
        });
    } else {
        makeSelect.disabled = true;
    }
}

function updateModels() {
    const yearSelect = document.getElementById('year-select');
    const makeSelect = document.getElementById('make-select');
    const modelSelect = document.getElementById('model-select');
    
    const selectedYear = yearSelect.value;
    const selectedMake = makeSelect.value;
    
    modelSelect.innerHTML = '<option value="">Select Model</option>';
    
    if (selectedYear && selectedMake && vehicleData[selectedYear] && vehicleData[selectedYear][selectedMake]) {
        modelSelect.disabled = false;
        const models = vehicleData[selectedYear][selectedMake];
        
        models.forEach(model => {
            const option = document.createElement('option');
            option.value = model;
            option.textContent = model;
            modelSelect.appendChild(option);
        });
    } else {
        modelSelect.disabled = true;
    }
}

function saveVehiclePreferences() {
    const year = document.getElementById('year-select').value;
    const make = document.getElementById('make-select').value;
    const model = document.getElementById('model-select').value;
    
    if (year && make && model) {
        const vehicleInfo = {
            year: year,
            make: make,
            model: model
        };
        
        localStorage.setItem('savedVehicle', JSON.stringify(vehicleInfo));
        
        const savedMessage = document.getElementById('saved-message');
        savedMessage.classList.add('show');
        setTimeout(() => {
            savedMessage.classList.remove('show');
        }, 2000);
        
        updateVehicleDisplay(vehicleInfo);
    } else {
        alert('Please select year, make, and model before saving.');
    }
}

function loadSavedVehicle() {
    const savedVehicle = localStorage.getItem('savedVehicle');
    
    if (savedVehicle) {
        const vehicleInfo = JSON.parse(savedVehicle);
        
        document.getElementById('year-select').value = vehicleInfo.year;
        updateMakes();
        
        setTimeout(() => {
            document.getElementById('make-select').value = vehicleInfo.make;
            updateModels();
            
            setTimeout(() => {
                document.getElementById('model-select').value = vehicleInfo.model;
            }, 100);
        }, 100);
        
        updateVehicleDisplay(vehicleInfo);
    }
}

function updateVehicleDisplay(vehicleInfo) {
    const selectedVehicleDiv = document.getElementById('selected-vehicle');
    const vehicleDisplay = document.getElementById('vehicle-display');
    
    vehicleDisplay.textContent = `${vehicleInfo.year} ${vehicleInfo.make} ${vehicleInfo.model}`;
    selectedVehicleDiv.style.display = 'block';
}