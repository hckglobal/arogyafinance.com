@extends('website.app')

@section('title')
Application for {{$type}}
@endsection

@section('styles')
    <!-- Loading Plugin -->
    <script src="/assets/js/isLoading.min.js"></script>
    <!-- boootsrap -->
    <link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.auto-complete.css"/>

@endsection

@section('content')

<div class="container">
    <div class="row">
        <!-- Panel Wizard Form Container -->
        <div class="panel paddingtop-class">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <!-- Steps -->
                <div class="pearls row">
                    <div class="pearl done col-xs-4">
                        <div class="pearl-icon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                        </div>
                        <span class="pearl-title">{{trans('steps.step_no.1')}}</span>
                    </div>
                    <div class="pearl current col-xs-4">
                        <div class="pearl-icon"><i class="glyphicon glyphicon-credit-card" aria-hidden="true"></i>
                        </div>
                        <span class="pearl-title">{{trans('steps.step_no.2')}}</span>
                    </div>
                    <div class="pearl col-xs-4">
                        <div class="pearl-icon"><i class="glyphicon glyphicon-file" aria-hidden="true"></i>
                        </div>
                        <span class="pearl-title">{{trans('steps.step_no.3')}}</span>
                    </div>
                </div>
                 <!-- End Steps -->
                <!-- Wizard Content -->
                <form id="financial_details" class="wizard-content" action="/apply/{{$type}}/financial-details/{{$id}}?locale={{$locale}}" method="POST">
                  

                    <div class="wizard-pane active" id="exampleBillingOne" role="tabpanel">

                        @include('website.pages.application.partials.income')

                        @include('website.pages.application.partials.liablities')

                        <!-- @include('website.pages.application.partials.assets') -->

                        @include('website.pages.application.partials.other_earnings')

                        @include('website.pages.application.partials.financials')

                    </div>
                    <input class="btn btn-primary btn-outline pull-right" type="submit" value="Next">
                </form>
                <!-- Wizard Content -->
            </div>
        </div>
        <!-- End Panel Wizard Form Container -->
    </div>
</div>

@endsection

@section('script')
<!-- vue js app files -->
<script type="text/javascript" src="/assets/js/vue.min.js"></script>
<script type="text/javascript" src="/assets/js/application.vue.js"></script>

<!-- form wizard files -->
<script type="text/javascript" src="/assets/js/form-wizard.js"></script>
<script type="text/javascript" src="/assets/js/jquery.auto-complete.min.js"></script>
<script type="text/javascript" src="/assets/js/formvalidation.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/form-wizard-config.js"></script>

<script type="text/javascript">

$('.hospital_name').autoComplete({
    minChars: 2,
    source: function(term, suggest){
        term = term.toLowerCase();
        var choices = {!! $hospitals !!};
        var matches = [];
        for (i=0; i<choices.length; i++)
            if (~choices[i].toLowerCase().indexOf(term)) matches.push(choices[i]);
        suggest(matches);
    }
});

$('.treatment_type').autoComplete({
    minChars: 2,
    source: function(term, suggest){
        term = term.toLowerCase();
        var choices = ["Ablative Laser Resurfacing","Abnormal Pap Smears","Achilles Tendon Rupture","Achilles Tendonitis","ACL Tear","Acromegaly","Acupuncture","Acute Lymphoblastic Leukemia","Acute Myeloid Leukemia","Acute Pancreatitis","Adrenal Disorders","Adrenal Insufficiency","Advanced Endoscopic Procedures","AIDS","AIDS-related Cancer","AIDS-related Lymphoma","Allogeneic Transplant","Allogenic Transplant","ALS","Alzheimer's Disease","Amyloidosis","Amyotrophic Lateral Sclerosis","Anal Cancer","Anemia","Aneurysm (Abdominal and Others)","Aneurysm, Conventional Surgery","Ankle Fracture","Ankle Sprain","Ankylosing Spondylitis","Aortic Coarctation","Apnea","Arrhythmia","Arterial Blockages","Arteriovenous Malformation","Arthritis and Inflammatory Bowel Disease","Arthritis of Inflammatory Bowel Disease","Arthritis of the Shoulder","Asbestosis","Atrial Fibrillation","Atrial Flutter","Atrial Septal Defect","Atrial Tachycardia","Autoimmune Hepatitis","Autologous Transplant","Autosomal Dominant Polycystic Kidney Disease","Bacterial Endocarditis","Bariatric Surgery","Basal Cell and Squamous Cell Carcinoma","Biofeedback","Bladder Cancer","Blood and Marrow Transplant","Blood Diseases","Bone Cancer","Botox","Brachytherapy","Brain Aneurysm","Brain Mapping","Brain Tumor","Brain Tumors","Breast Cancer","Bronchiectasis","Bunion","Cancer","Carotid Artery Disease","Cartilage Repair","Cataracts","Catheter Ablation","Cavernous Malformations","Cervical Cancer","Cervical Disc Herniation","Cervical Stenosis","Cholangiocarcinoma","Chronic Beryllium Disease","Chronic Bronchitis","Chronic Lymphocytic Leukemia","Chronic Myelogenous Leukemia","Chronic Obstructive Pulmonary Disease","Chronic Pancreatitis","Cirrhosis","Clavicle Fracture","Cleft Lip and Palate","Cluster Headaches","Cochlear Implants","Collagen Replacement","Colon Cancer","Colorectal Cancer","Complete Heart Block","Congenital Heart Disease","Connective Tissue Disease-Associated ILD","Constipation","Conventional Aneurysm Surgery","Coronary Artery Disease","Corticobasal Degeneration","Creutzfeldt-Jakob Disease","Crohn's Disease","Cryopreservation","CT-Guided Spinal Injections","Cushing's Syndrome","CyberKnife","Dancer's Heel","Deep Brain Stimulation","Dental Implants","Dermatology","Diabetes Insipidus","Diabetes Mellitus","Diarrhea","Digestive Disorders","Disc Herniation","Disc Replacement","Disconnection Procedures","Disconnection Procedures\n ","Donor Sperm Insemination","Dupuytren's Contracture","Dural Arteriovenous Fistulae","Ear Reshaping","Ear, Nose & Throat","Ebstein Anomaly","Eisenmenger's Syndrome","Emphysema","Endocarditis","Endocrinology","Endometrial Cancer","Endometriosis","Endovascular Procedures (Advanced)","Endovascular Surgery","Enterocutaneous Fistula","Epidural Injections","Epilepsy","Erectile Dysfunction","Esophageal Cancer","Extracorporeal Membrane Oxygenation","Extreme Lateral Interbody Fusion","Eye Disorders","Eyelid Surgery","Facelift","Facial Injury","Facial Paralysis","Fallopian Tube Cancer","Fibroids","Focal Resection","Frontotemporal Dementia","Frozen Shoulder","Gallstones","Gamma Knife","Ganglion Cyst","Gastric Electrical Stimulation","Gastrointestinal Cancer","Gastroparesis","Genetic Heart Disorders","Genitourinary Tract Injuries","Glenoid Labrum Tear","Gout","Growth Hormone Deficiency","Gynecologic Cancer","Gynecological Conditions","Hammertoe","Hand and Wrist Fractures","Head and Neck Cancer","Headache","Hearing Aids","Hearing and Balance Disorders","Hearing Loss","Heart Disease","Heart Failure","Heart Transplant","Heartburn","HeartWare","Heavy, Irregular or Painful Periods","Hemochromatosis","Hemophilia","Hepatic Porphyria","High-Risk Pregnancy","Hip Bursitis","Hip Labral Tear","Hip Replacement","HIV","Hodgkin's Lymphoma","Huntington's Disease","Hyperacusis","Hyperhidrosis","Hyperparathyroidism","Hypersensitivity Pneumonitis","Hyperthermia","Hyperthyroidism","Hypertrophic Cardiomyopathy","Hypogonadism","Hypothyroidism","Hysterectomy","Idiopathic Pulmonary Fibrosis","Immune Thrombocytopenia","Impacted Wisdom Teeth","Implantable Cardioverter Defibrillator","In Vitro Fertilization (IVF)","Incontinence","Infectious Diseases","Infertility in Men","Infertility in Women","Infertility","Insomnia","Integrative Medicine Consultation","Integrative Psychiatry","Intensity Modulated Radiation Therapy","Interstitial Lung Disease","Intestinal Failure","Intestinal Transplant","Intra-Uterine Insemination","Intra-Uterine_Insemination","Intrathecal Drug Delivery","Irritable Bowel Syndrome","Islet Autotransplantation for Chronic Pancreatitis","Islet Transplant for Type I Diabetes","Jaw Deformity","Jaw Tumors and Cysts","Joint Injections","Kaposi's Sarcoma","Kidney Cancer","Kidney Transplant","Knee Replacement","Kyphosis","Laparoscopic Surgery for the Kidney Donor","Larynx Cancer","Laser Hair Removal","Laser Tattoo Removal","Laser Vision Correction Surgery","LCL Tear","Leber Congenital Amaurosis (LCA)","Leber Congenital Amaurosis","Leukemia","Lewy-Body Dementia","Liver Cancer","Liver Disease","Liver Transplant","Living Kidney Donor Transplant","Living Liver Donor Transplant","Long QT Syndrome","Lumbar Disc Herniation","Lumbar Stenosis","Lung Cancer","Lung Disease (Occupational)","Lung Transplant","Lupus","Lymphoma","Lynch Syndrome","Magnetic Navigation","Marfan Syndrome","Massage","MCL Tear","Medical Abortion","Melanoma","Memory Disorders","Menopause","Menstrual Periods (Heavy, Irregular or Painful)","Microvascular Head and Neck Reconstruction","Migraine","Mild Cognitive Impairment","Mitral Valve Disorders","Mitral Valve Prolapse","Mixed Incontinence in Women","Mohs Micrographic Surgery","Multiple Myeloma","Multiple Sclerosis","Myelodysplastic Syndromes","Myeloproliferative Disorders","Myomectomy","Narcolepsy","Nasal Reconstruction","Nasal Trauma","Nerve Blocks","Neurological Disorders","Neuromonics","Nicotine Dependence","Non-Alcoholic Fatty Liver Disease","Non-Hodgkin's Lymphoma","Nontuberculous Mycobacteria","Obesity","Occupational Lung Disease","Oral and Facial Disorders","Oral Cancer","Organ Transplant","Orthopedics","Orthovoltage","Osteoarthritis of the Hand","Osteoarthritis of the Hip","Osteoarthritis of the Knee","Osteoporosis","Osteoradionecrosis","Ovarian Cancer","Ovarian Masses","Pancreas Transplant","Pancreatic Cancer","Pancreatitis (Acute)","Pancreatitis (Chronic)","Pap Smears, Abnormal","Parkinson's Disease","Patellofemoral Pain Syndrome","PCL Tear","Pelvic Organ Prolapse","Pelvic Pain","Periodic Leg Movements","Peripheral Artery Disease","Peripheral Neuropathy","Peritoneal Cancer","Peyronie's Disease","Pheochromocytoma","Photodynamic Therapy","Pituitary Disorders","Pituitary Tumor","Pituitary Tumors","Plantar Fasciitis","Polycystic Kidney Disease, Autosomal Dominant","Polycystic Ovarian Syndrome","Porphyria","Post-Herpetic Neuralgia","Pre-Implantation Genetic Diagnosis","Pregnancy","Pregnancy, High Risk","Priapism","Primary Biliary Cirrhosis","Primary Sclerosing Cholangitis","Progressive Supranuclear Palsy","Prostate Cancer","Proton Therapy for Ocular Melanoma","Psoriatic Arthritis","Pulmonary Disorders","Pulmonary Hypertension","Pulmonary Stenosis","Radical Prostatectomy","Radiofrequency Ablation","Reactive Arthritis","Rectal Cancer","Recurrent Pregnancy Loss","Responsive Neurostimulation","Retinitis Pigmentosa","Rheumatic Disorders","Rheumatoid Arthritis","Robotic Radical Prostatectomy","Rotator Cuff Tear","Salivary Gland Cancer","Sarcoidosis","Scar Revision","Scleroderma","Sclerotherapy","Scoliosis","Seasonal Affective Disorder","Separated Shoulder","Sexually Transmitted Diseases","Shoulder Dislocation","Shoulder Fracture","Shoulder Impingement Syndrome","Shoulder Replacement","Silicosis","Sjogren's Syndrome","Skin Cancer","Skin Resurfacing","SLAP Tear","Sleep Apnea","Sleep Disorders","Soft Tissue Fillers","Spinal Cord Stimulation","Spinal Cord Tumor","Spinal Fusion Surgery for Scoliosis","Spine Deformities","Spine Trauma","Spine","Spondyloarthritis","Spondylolisthesis","Stargardt Disease","Stenosis","Stomach Cancer","Stress Fracture","Stress Incontinence in Women","Stroke","Supraventricular Tachycardia","Surgical Abortion (First Trimester)","Surgical Abortion (Second Trimester)","Temporomandibular Joint Disorders","Tennis Elbow","Tension Headaches","Testicular Cancer","Tetralogy of Fallot","Thoracic Disc Herniation","Throat Cancer","Thyroid Cancer","Thyroid Disorders","Thyroid Nodules and Goiter","Tinnitus","Toxic Hepatitis","Transanal Endoscopic Microsurgery","Transposition of the Great Arteries","Trigeminal Neuralgia","Trochanteric Bursitis","Trochanteric or Hip Bursitis","Tumescent Liposuction","Ulcerative Colitis","Ulcers","Urethral Injuries","Urge Incontinence in Women","Urinary Tract Infections","Urologic Cancer","Urology","Uterine Artery Embolization","Uterine Bleeding","Vagal Nerve Stimulation","Vaginal Cancer","Vaginitis","Vascular Dementia","Vascular Disorders","Vasculitis","Venous Thrombosis","Ventral Hernia","Ventricular Assist Device","Ventricular Fibrillation","Ventricular Septal Defect","Ventricular Tachycardia","Vertigo","Viral Hepatitis","Virtual Colonoscopy","Visualase Thermal Laser Ablation","Vulvar Cancer","Wolff-Parkinson-White Syndrome","X-linked Retinoschisis","X-Linked Retinoshisis"];
        var matches = [];
        for (i=0; i<choices.length; i++)
            if (~choices[i].toLowerCase().indexOf(term)) matches.push(choices[i]);
        suggest(matches);
    }
});

</script>
@endsection
