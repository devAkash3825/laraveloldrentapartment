@extends('user/layout/app')
@section('content')
@section('title', 'RentApartement | Privacy Promise ')
<div id="breadcrumb_part" style="background-image:url('images/breadcroumb_bg.jpg')">
    <div class="bread_overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <h4> Privacy Promise </h4>
                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Privacy Promise </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container my-5">
    <div class="row">
        <div class="col-md-12 pt-3">
            <div>
                <h6 class="px-2 py-1" style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> WELCOME TO
                    VITA LOCATORS </h6>
            </div>
            <p class="text-secondary mt-1" style="line-height: 2;">Information about our customers is the heart of our
                business. We cannot be a successful business without collecting certain personal information, but we
                make this Privacy Promise. We are not in the business of selling it to others. You may use our site to
                communicate with advertisers. Although we cannot control the privacy practices of companies not owned or
                managed by Rentapartments.info, we try to do business only with companies that follow practices at least
                as protective as those described in this Privacy Promise. A & A Locators provides informational services
                to you subject to the following conditions. If you visit Vita Locators, you accept these conditions.
                Please read them carefully.</p>
        </div>
        <div class="col-md-12 pt-1 mt-3">
            <div>
                <h6 class="px-2 py-1" style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> ELECTRONIC
                    COMMUNICATIONS </h6>
            </div>
            <p class="text-secondary " style="line-height: 2;">When you visit Vita Locators, call us, or send
                e-mails to us, you are communicating with us and consent to receive communications from us. We will
                communicate with you by e-mail, by posting notices on this site, or upon request by telephone. You agree
                that all agreements, notices, disclosures and other communications that we provide to you electronically
                satisfy any legal requirement that such communications be in writing.</p>

            <p class="text-secondary mt-4" style="line-height: 2;">Promotional Offers: Sometimes we send offers to
                selected users of Vita Locators. You may opt out at any time if you do not want to receive such offers
                by emailing your request to customer service. Please understand that if you do so, we will inactivate
                your account.</p>


            <p class="text-secondary mt-4" style="line-height: 2;">Protection of Vita Locators and Others: We release
                account and other personal information when we believe release is appropriate to comply with the law; to
                get paid for our service, and to protect the property or safety of Vita Locators, our users, or others.
                This includes exchanging information with other companies and organizations for fraud protection and
                credit risk reduction. Obviously, however, this does not include selling, renting, sharing, or otherwise
                disclosing personally identifiable information from customers for commercial purposes in violation of
                the commitments set forth in this Privacy Promise.</p>

            <p class="text-secondary mt-4" style="line-height: 2;">With Your Consent: When you use our site to
                communicate with us and advertisers on Vita Locators, you consent to release information you have
                voluntarily provided.</p>
        </div>


        <div class="col-md-12 pt-1 mt-3">
            <div>
                <h6 class="px-2 py-1" style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> YOUR ACCOUNT
                </h6>
            </div>
            <p class="text-secondary" style="line-height: 2;">If you use this site, you are responsible for maintaining
                the confidentiality of your account and password and for restricting access to your computer, and you
                agree to accept responsibility for all activities that occur under your account or password. Vita
                Locators and its affiliates reserve the right to refuse service, terminate accounts, remove or edit
                content, or cancel accounts in their sole discretion.</p>
        </div>


        <div class="col-md-12 pt-1 mt-3">
            <div>
                <h6 class="px-2 py-1" style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> PRODUCT
                    PRICES AND DESCRIPTIONS </h6>
            </div>
            <p class="text-secondary " style="line-height: 2;">
                It is our goal to be as accurate as possible. However, A & A Locators does not warrant that product
                prices, descriptions or other content of this site is accurate, complete, reliable, current, or
                error-free. The price displayed for products on our website represents the price posted by the company
                listing the product. It is the advertiser's responsibility, not Vita Locators, to keep such information
                current. Prices are an estimate only, not an offer to sell, and may or may not represent the prevailing
                price on any particular day. If a product on Vita Locators itself is not as described, your sole remedy
                is to not purchase the product
            </p>
        </div>

        <div class="col-md-12 pt-1 mt-3">
            <div>
                <h6 class="px-2 py-1" style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> LINKS TO
                    OTHER WEBSITES </h6>
            </div>
            <p class="text-secondary " style="line-height: 2;">
                We provide links to the sites of companies offering products on our website. We are not responsible for
                examining or evaluating, and we do not warrant the offerings of, any of these businesses or individuals
                or the content of their Web sites. Vita Locators does not assume any responsibility or liability for the
                actions, product, and content of all these and any other third parties. You should carefully review
                their privacy statements and other conditions of use.
            </p>
        </div>

        <div class="col-md-12 pt-1 mt-3">
            <div>
                <h6 class="px-2 py-1" style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> COPYRIGHT
                </h6>
            </div>
            <p class="text-secondary " style="line-height: 2;">
                All content on Vita Locators is the property of Vita Locators and its content suppliers and protected by
                United States and international copyright laws. The compilation of all content on this site is the
                exclusive property of Vita Locators and protected by U.S. and international copyright laws.
            </p>
        </div>

        <div class="col-md-12 pt-1 mt-3">
            <div>
                <h6 class="px-2 py-1" style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> Conditions of
                    Use, Notices, and Revisions </h6>
            </div>
            <p class="text-secondary " style="line-height: 2;">
                All content on Vita Locators is the property of Vita Locators and its content suppliers and protected by
                United States and international copyright laws. The compilation of all content on this site is the
                exclusive property of Vita Locators and protected by U.S. and international copyright laws. If you have
                any concern about privacy at Vita Locators, please contact customer service with a thorough description,
                and we will try to resolve it. Our business changes constantly and our Privacy Promise will change also.
                You should check our Web site frequently to see recent changes. Unless stated otherwise, our current
                Privacy Promise applies to all information that we have about you and your account. We stand behind the
                promises we make, however, and will never materially change our policies and practices to make them less
                protective of customer information collected in the past without the consent of affected customers.
            </p>
        </div>

    </div>
    {{-- <div class="row mt-5">
        <div class="col-md-12 mx-auto">
            <p style="font-weight: 600;text-align:left;font-size: 1.4rem;">If your employees need a house rental or
                guided tour we also
                provide affordable paid services. </p>
            <p class="h5 mb-4" style="font-weight: 600;">About <span style="color: #94c045;">Paid Services:</span></p>
            <p style="text-align:left;">Full needs assessment by rental consultant to determine rental criteria,
                including area, budget, special needs and commute times
                Research and option process, including scheduling of appointments
                Scheduled tour, set appointments and transportation to rentals
                Area tour and information included with guided tours and private home searches
                Extensive follow-up with you to insure successful rental process
                If employee is not present our rental assistants will tour the private rentals, take pictures, advise,
                and help with the rental process.
            </p>
            <hr>
            <p class="h5 mb-4" style="font-weight: 600;">About <span style="color: #94c045  ;">Prices:</span></p>
            <p style="text-align:left;">
                Half-Day Tour (3-4 hours) includes comprehensive research of rental options, appointments to 4-6
                communities, and any additional relocation services, as requested. Cost: $400.00
                Full Day Tour (5-7 hours) includes rental options, 5-8 community appointments, orientation and preview
                of area. May include additional relocation services, as requested. Cost: $600.00
            </p>
            <p style="text-align:left;">If you are unfamiliar with the local rental market, and your time is at a
                premium, the Rental Tour is a great option to consider because we know Denver. As the leader in
                apartment finding, Vita maintains excellent relationships with hundreds of landlords. With such a large
                sponsorship, we know we can find the rental you are looking for!</p>

            <p style="text-align:left;">We work with all major employers. Using our professional rental consultants can
                alleviate the demands of starting a new job and relocating. We have the local experience and expertise
                to identify needs and options in a timely fashion and take the stress out of your move. Your employer
                may also cover the cost of your tour as part of your relocation benefits.</p>

            <p style="text-align:left;">We take you where you want to live and will tailor your tour to your exact
                needs. Our service covers all suburban and metropolitan areas that make up the Denver Metro. We're the
                experts at finding a place you'll love to call home!
            </p>
            <hr>
            <p class="h5 mb-4" style="font-weight:600;text-align:center;">About <span style="color:#94c045;">Additional
                    Services:</span></p>
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li>Hotel or Airport Pick-up</li>
                        <li> City or Neighborhood Tours</li>
                        <li>School Information</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li>Furniture Rental Assistance</li>
                        <li>Moving Company Information</li>
                        <li>Insurance Information</li>
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
