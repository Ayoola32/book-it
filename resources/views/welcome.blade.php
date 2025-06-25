
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"
        integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body>


    <div class="container">
        <div class="booking-container">
            <div class="booking-header">
                <h2><i class="bi bi-calendar-check"></i> BookingEase </h2>
                <p class="mb-0">Book your appointment in a few simple steps</p>
            </div>

            <div class="booking-steps position-relative">
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-title">Category</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-title">Service</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                    <div class="step-title">Staff</div>
                </div>


                <div class="progress-bar-steps">
                    <div class="progress"></div>
                </div>
            </div>

            <div class="booking-content">
                <!-- Step 1: Category Selection -->
                <div class="booking-step active" id="step1">
                    <h3 class="mb-4">Select a Category</h3>
                    <div class="row row-cols-1 row-cols-md-3 g-4" id="categories-container">
                        <!-- Categories will be inserted here by jQuery -->
                    </div>
                </div>

                <!-- Step 2: Service Selection -->
                <div class="booking-step" id="step2">
                    <h3 class="mb-4">Select a Service</h3>
                    <div class="selected-category-name mb-3 fw-bold"></div>
                    <div class="row row-cols-1 row-cols-md-3 g-4" id="services-container">
                        <!-- Services will be loaded dynamically based on category -->
                    </div>
                </div>

                <!-- Step 3: Employee Selection -->
                <div class="booking-step" id="step3">
                    <h3 class="mb-4">Select a Staff Member</h3>
                    <div class="selected-service-name mb-3 fw-bold"></div>
                    <div class="row row-cols-1 row-cols-md-3 g-4" id="employees-container">
                        <!-- Employees will be loaded dynamically based on service -->
                    </div>
                </div>


            </div>

            <div class="booking-footer">
                <button class="btn btn-outline-secondary" id="prev-step" disabled>
                    <i class="bi bi-arrow-left"></i> Previous
                </button>
                <button class="btn btn-primary" id="next-step">
                    Next <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <footer>
        <div class="container pb-2">
            <div class="row text-center">
            <span>Developed by <a href="#">Abusidiq</a></span>
            </div>
        </div>
    </footer>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        // Step 1 - Inject the categories and employees as JSON variables
        const categories = @json($categories);
        const employees = @json($employees);


        // Step 2 - Add bookingState object to manage the booking process
        let bookingState = {
            currentStep: 1,
            selectedCategory: null,
            selectedService: null,
            selectedEmployee: null
        };

        // Step 3 - Load Categories
        $(document).ready(function () {
            const container = $('#categories-container');
            let html = '';

            $.each(categories, function(index, category) {
                html += `
                    <div class="col">
                        <div class="card category-card text-center border p-3 h-100" data-category="${category.id}">
                            <div class="card-body">
                                <h5 class="card-title">${category.name}</h5>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.html(html);
        });

        // Step 4 - Handle Category Click → Show Services
        $(document).on("click", ".category-card", function () {
            $(".category-card").removeClass("selected");
            $(this).addClass("selected");

            const categoryId = $(this).data("category");
            bookingState.selectedCategory = categoryId;

            // Get selected category title
            const selectedCategory = categories.find(c => c.id == categoryId);
            $(".selected-category-name").text(`Selected Category: ${selectedCategory?.name || ''}`);

            // Clear service selection and staff
            bookingState.selectedService = null;
            bookingState.selectedEmployee = null;

            $("#services-container").empty();
            $("#employees-container").empty();
        });


        // STEP 5 - Load services based on selected category
        $("#next-step").click(function () {
            const step = bookingState.currentStep;

            if (!validateStep(step)) return;

            if (step === 1) {
                loadServices();
            } else if (step === 2) {
                loadEmployees();
            }

            goToStep(step + 1);
        });

        $("#prev-step").click(function () {
            if (bookingState.currentStep > 1) {
                goToStep(bookingState.currentStep - 1);
            }
        });



        // STEP 6 - goToStep and validateStep
        function goToStep(step) {
            $(".booking-step").removeClass("active");
            $(`#step${step}`).addClass("active");

            $(".step").removeClass("active completed");
            for (let i = 1; i <= 3; i++) {
                if (i < step) $(`.step[data-step='${i}']`).addClass("completed");
                else if (i === step) $(`.step[data-step='${i}']`).addClass("active");
            }

            bookingState.currentStep = step;
            updateProgressBar();
            updateNavigationButtons();
        }

        function updateProgressBar() {
            const progress = ((bookingState.currentStep - 1) / 2) * 100;
            $(".progress-bar-steps .progress").css("width", `${progress}%`);
        }

        function updateNavigationButtons() {
            $('#prev-step').prop('disabled', bookingState.currentStep === 1);
        }



        // STEP 7 - Validate Step
        function validateStep(step) {
            if (step === 1 && !bookingState.selectedCategory) {
                alert("Please select a category");
                return false;
            }
            if (step === 2 && !bookingState.selectedService) {
                alert("Please select a service");
                return false;
            }
            return true;
        }


        // STEP 8 - Load Services
        function loadServices() {
            const category = categories.find(c => c.id == bookingState.selectedCategory);
            const services = category.sub_categories ?? [];

            let html = '';
            services.forEach(service => {
                html += `
                    <div class="col">
                        <div class="card border service-card text-center p-2 h-100" data-service="${service.id}">
                            <div class="card-body">
                                <h5 class="card-title">${service.name}</h5>
                            </div>
                        </div>
                    </div>
                `;
            });

            $("#services-container").html(html);
        }

        // STEP 9 - Handle Service Click → Show Employees
        $(document).on("click", ".service-card", function () {
            $(".service-card").removeClass("selected");
            $(this).addClass("selected");

            const serviceId = $(this).data("service");
            const category = categories.find(c => c.id == bookingState.selectedCategory);
            const service = category.sub_categories.find(s => s.id == serviceId);

            bookingState.selectedService = service;
            bookingState.selectedEmployee = null;

            $(".selected-service-name").text(`Selected Service: ${service.name}`);
            $("#employees-container").empty();
        });




        // STEP 4: Load Employees for the Selected Service
        function loadEmployees() {
            const service = bookingState.selectedService;
            const employees = service.employees ?? [];

            let html = '';

            if (employees.length === 0) {
                html = `<div class="col-12 text-center py-4">
                            <div class="alert alert-warning">
                                No staff available for this service.
                            </div>
                        </div>`;
            } else {
                employees.forEach(employee => {
                    let roleText;
                    if (employee.user.role === 'employee') {
                        roleText = 'Staff Member';
                    } else {
                        roleText = employee.user.role ?? 'Staff Member';
                    }
                    html += `
                        <div class="col">
                            <div class="card border employee-card text-center p-2 h-100" data-employee="${employee.id}">
                                <div class="card-body">
                                    <h5 class="card-title">${employee.user.name}</h5>
                                    <p class="card-text">${roleText}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            $("#employees-container").html(html);
        }

        // Step 10 - Handle Employee Click → Select Employee
        $(document).on("click", ".employee-card", function () {
            $(".employee-card").removeClass("selected");
            $(this).addClass("selected");

            const employeeId = $(this).data("employee");
            const service = bookingState.selectedService;
            const selectedEmployee = service.employees.find(e => e.id == employeeId);

            bookingState.selectedEmployee = selectedEmployee;
        });






    </script>



</body>

</html>
