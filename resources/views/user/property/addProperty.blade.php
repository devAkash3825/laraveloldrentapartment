@extends('user.layout.app')
@section('content')
<div id="breadcrumb_part"
    style="background: url(../images/breadcroumb_bg.jpg);
        background-size:cover;
        background-repeat:no-repeat;
        background-position: center;">
    <div class="bread_overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <h4>Add Property </h4>
                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Add Property </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="listing_grid" class="grid_view">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9 mt-lg-0 px-4">
                <div>
                    @include('user.partials.add_property_form')
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Www.rentapartments.info TERMS AND CONDITIONS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 pt-3">
                            <p class="text-secondary mt-2" style="line-height: 2;">PLEASE READ THIS AGREEMENT
                                CAREFULLY. TO COMPLETE YOUR REGISTRATION FOR Www.rentapartments.info AND ACTIVATE YOUR
                                LISTING YOU MAY DIGITALLY ACCEPT THE TERMS OR FILL OUT THE INFORMATION AT THE BOTTOM OF
                                THIS PAGE AND FAX TO 303-649-0706. FOR QUESTIONS PLEASE CALL CUSTOMER SERVICE AT
                                303-649-0705 OR TOLL FREE 1-800-506-6647.</p>

                            <p class="text-secondary mt-2" style="line-height:2;">As part of our commitment to
                                high-quality service, we believe it is important to have a clear understanding with you
                                regarding our respective obligations. These Terms and Conditions constitute the
                                agreement between you, the Client (referred to as Client, owner, or you), and
                                Www.rentapartments.info, an Vita LLC company (referred to as Www.rentapartments.info, us
                                or we).</p>

                            <p class="text-secondary mt-2" style="line-height:2;">
                                By listing a community on Www.rentapartments.info you are creating an account with us
                                and thereby becoming a Client. You agree to be legally bound by these Terms and
                                Conditions as well as any other policies or procedures disclosed on the
                                Rentapartments.info web site without modification. Rentapartments.info reserves the
                                right to modify these Terms and Conditions at any time by notifying you of such changes
                                or posting such changes on our web site. You acknowledge and agree that it is your
                                responsibility to review this site regularly to review the Terms and Conditions that are
                                binding on you.
                            </p>
                        </div>

                        <div class="col-md-12 pt-1 mt-5">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.4rem; background-color:#243642;"> CLIENT
                                    IDENTITY </h6>
                            </div>
                            <p class="text-secondary " style="line-height: 2;">Rentapartments.info cannot and will not
                                confirm that any Client is who they claim to be or that any Client has the rights or
                                qualifications they claim to have. As such, you represent and warrant that you are the
                                owner or agent for owner and have exclusive right to request services provided by
                                Rentapartments.info, including without limitation all payments for requested services.
                            </p>
                        </div>

                        <div class="col-md-12 pt-1 mt-3">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> AUTHORIZATION
                                </h6>
                            </div>
                            <p class="text-secondary" style="line-height:2;">Owner authorizes Rentapartments.info to
                                furnish information to prospective residents about the availability, features, and
                                rental terms concerning the property of which owner has informed Rentapartments.info.
                                Owner agrees to keep Rentapartments.info informed on a current basis of the above items
                                and of the rental status of all prospective residents referred to owner. Owner agrees
                                not to collect any portion of the fee from the resident and the resident shall be
                                offered the same rental terms, conditions, prices and specials as those offered to the
                                general public.
                            </p>

                        </div>

                        <div class="col-md-12 pt-1 mt-3">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> REGISTRATION
                                    DATA, CLIENT INFORMATION PRIVACY
                                </h6>
                            </div>
                            <p class="text-secondary" style="line-height:2;">In order to register for and access the
                                services provided by Rentapartments.info, you will provide certain information and data
                                and update the same periodically. This will include, but not be limited to, registering
                                as a Client for Rentapartments.info services, making revisions to your community
                                information, or otherwise providing Rentapartments.info information that enables us to
                                initiate, continue, or complete the services provided by Rentapartments.info. By
                                providing such information and data, you agree and represent that all such information
                                and data is true and accurate, and update the same as needed in order to keep it
                                current, complete and accurate. You also grant us the right to disclose to third parties
                                certain data about you. Rentapartments.info assumes no responsibility for any errors,
                                omissions or inaccuracies in the services provided that stem from such inaccurate or
                                incomplete information.
                            </p>

                        </div>

                        <div class="col-md-12 pt-1 mt-3">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> ACCOUNT ACCESS
                                </h6>
                            </div>
                            <p class="text-secondary" style="line-height:2;">In becoming a Client, you have provided
                                Rentapartments.info with a username and password with which to access your account. You
                                are responsible for maintaining the confidentiality of your account and password and for
                                restricting access to your computer, and you agree to accept complete responsibility for
                                all activities that occur under your account or recompilation, disassembly or other
                                reverse engineering of this site or any products or services provided on this site.
                            </p>

                        </div>

                        <div class="col-md-12 pt-1 mt-3">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> FEES
                                </h6>
                            </div>
                            <p class="text-secondary" style="line-height:2;">In the event that Rentapartments.info,
                                website for Apartment Guyz LLC is responsible for referring a resident who subsequently
                                is accepted by owner for residency in this or any other rental property owned or managed
                                by owner or property, owner agrees to pay Apartment Guyz LLC a sum equal to (55%) of the
                                first full months contractual rent. Apartment Guyz LLC reserves the right to request a
                                copy of the lease page verifying contractual rent. In the event the resident is evicted
                                or abandons his lease before the first ninety days, a charge back to Apartment Guyz LLC
                                in the amount of 25% will be allowed. In the event a short term stay, if offered
                                (corporate suites, less than 3-month lease), a sum of 18.33% of each months contractual
                                rent will be charged to the property for each month the resident stays up to 3-months.
                            </p>

                        </div>

                        <div class="col-md-12 pt-1 mt-3">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> PAYMENT AND
                                    COLLECTION
                                </h6>
                            </div>
                            <p class="text-secondary" style="line-height:2;">Terms are net (30) days from the date of
                                move-in or invoice whichever is later. Owner agrees to pay a late fee of 1.25% of the
                                amount of the invoice, plus all collection costs incurred by Rentapartments.info for
                                accounts 60 days past due. Services will be suspended on all accounts over 60 days past
                                due.

                            </p>

                        </div>

                        <div class="col-md-12 pt-1 mt-3">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> TERMINATION
                                </h6>
                            </div>
                            <p class="text-secondary" style="line-height:2;">Either party may immediately terminate
                                this agreement by giving written notice of termination. In the event of termination
                                owner agrees to pay all referral fees generated or incurred prior to the receipt by
                                Rentapartments.info of written notice of such change. If Rentapartments.info is not
                                notified of any ownership or management changes stated above, this contract will remain
                                in full force to the new owner or management company.

                            </p>

                        </div>

                        <div class="col-md-12 pt-1 mt-3">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> RESIDENTS
                                </h6>
                            </div>
                            <p class="text-secondary" style="line-height:2;">The owner has the sole right to accept or
                                reject potential residents referred by Rentapartments.info. Rentapartments.info does not
                                warrant the suitability of the prospective residents referred to the owner?s property.
                                Accordingly, owner holds harmless Rentapartments.info for any and all damages arising
                                out of the acceptance or rejection of the residents referred by Rentapartments.info as
                                well as any present or future rents, damages, or other sums owed to owner by any
                                resident or incurred by owner.
                            </p>

                        </div>

                        <div class="col-md-12 pt-1 mt-3">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> SEVERABILITY
                                </h6>
                            </div>
                            <p class="text-secondary" style="line-height:2;">In the event that any provision of this
                                agreement shall be judged illegal or otherwise unenforceable, such provision shall be
                                enforced to the maximum extent permitted by applicable law, and the balance of the
                                agreement shall continue in full force and effect in accordance with its terms, provided
                                that it is the intent of the parties that this agreement is not materially altered.
                            </p>

                        </div>

                        <div class="col-md-12 pt-1 mt-3">
                            <div>
                                <h6 class="px-2 py-1"
                                    style="color: #94c045;font-size: 1.5rem; background-color:#243642;"> ENTIRE
                                    AGREEMENT, MODIFICATION AND WAIVER
                                </h6>
                            </div>
                            <p class="text-secondary" style="line-height:2;">This agreement merges all previous
                                negotiations between the parties hereto, supersedes all prior agreements, if any,
                                between the parties, and constitutes the entire agreement and understanding between the
                                parties with respect to the subject matter of this agreement. Alteration, modification
                                or change of this agreement shall be invalid except by written instrument in which any
                                such alteration, modification or change is specifically designated and which is
                                specifically acknowledged, agreed and executed by the party to be charged. The failure
                                of either party to exercise in any respect any right provided for herein shall not be
                                deemed a waiver of any right hereunder. No waiver of any provision hereof shall be
                                effective unless made in writing and signed by the waiving party. The failure of any
                                party to require the performance of any term or obligation of this agreement, or the
                                waiver by any party of any breach of this agreement, shall not prevent any subsequent
                                enforcement of such term or obligation or be deemed a waiver of any subsequent breach.
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    RENTAPARTMENTS.INFO
                                </div>
                                <div class="col-md-6">
                                    OWNER/AGENT FOR OWNER
                                </div>
                                <div class="col-md-6">
                                    BY: ________________________________
                                </div>
                                <div class="col-md-6">
                                    BY: ________________________________
                                </div>
                                <div class="col-md-6">
                                    TITLE: ______________________________
                                </div>
                                <div class="col-md-6">
                                    PRINT NAME:______________________________
                                </div>
                                <div class="col-md-6">
                                    800-506-6647
                                </div>
                                <div class="col-md-6">
                                    TELEPHONE NUMBER: _________________________
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection