    <!-- 5-Second Delayed Popup Lead Modal -->
    <div class="popup-modal" id="leadPopup">
        <div class="popup-container">
            <button class="popup-close" id="leadPopupClose"><i class="fa-solid fa-xmark"></i></button>
            <div class="popup-header">
                <div class="popup-icon"><i class="fa-solid fa-gift"></i></div>
                <h3>Get Sandbox Access!</h3>
                <p>Subscribe to our developers list and get instance sandbox access keys to test our layout editor.</p>
            </div>
            
            <form class="popup-form" id="popupLeadForm" method="POST" action="{{ route('software.contact.submit') }}">
                @csrf
                <input type="hidden" name="type" value="popup_newsletter">
                <div class="form-control-wrap">
                    <input type="email" name="email" class="input-field" placeholder="yourname@domain.com" required>
                </div>
                <button type="submit" class="btn-primary" style="justify-content: center;">Request Access</button>
            </form>
            <div id="popupLeadMsg" style="margin-top: 15px; text-align: center; font-size: 14px; font-weight: 500;"></div>
        </div>
    </div>
