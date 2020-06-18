<div>
    <form method="post" action="" >
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="baseFullname">Fullname</label>
            <div class="col-md-6">
                <input
                        type="password"
                        class="form-control"
                        placeholder="Your Fullname..."
                        id="baseFullname"
                />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="baseEmail">Email</label>
            <div class="col-md-6">
                <input type="password" class="form-control" placeholder="Your Email..." id="baseEmail" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="basePrice">Budget</label>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" />
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="formControlRange">Amount</label>
            <div class="col-md-6 pt-2">
                <input type="text" id="slider-1" class="form-control" name="example_name" value="" />
            </div>
        </div>
        <button type="button" class="btn btn-success px-5">Send Data</button>
    </form>
</div>
