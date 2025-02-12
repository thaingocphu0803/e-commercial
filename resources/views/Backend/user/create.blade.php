<x-backend.dashboard.layout>

    <x-slot:heading>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </x-slot:heading>

    <x-slot:script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $('.select2').select2();
        </script>
    </x-slot:script>

    <x-backend.dashboard.breadcrumb title="Add Member" />

    <form action="" method="" class="box">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">Common Information</h3>
                    <div class="pannel-description">Enter user information to create new member</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Common Information</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.user.form.input inputName="email" type="text" labelName='email'
                                    :must="true" />

                                <x-backend.user.form.input inputName="name" type="text" labelName='fullname'
                                    :must="true" />
                            </div>

                            <div class="row mt-20">
                                <x-backend.user.form.input inputName="birthday" type="date" labelName='birthday' />
                                <x-backend.user.form.select labelName="group member" name="user_catalouge_id" :must="true"/>
                            </div>

                            <div class="row mt-20">
                                <x-backend.user.form.input inputName="password" type="password" labelName='password'
                                    :must="true" />

                                <x-backend.user.form.input inputName="password_confirmed" type="password"
                                    labelName='password confirmed' :must="true" />
                            </div>

                            <div class="row mt-20">
                                <x-backend.user.form.input inputName="image" type="text" rowLength='12'
                                    labelName='Avatar' />
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">Contact Information</h3>
                    <div class="pannel-description">Contact information can be ignored</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Contact Information</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.user.form.select labelName="city" name="province_id" :data="$provinces"/>


                                <x-backend.user.form.select labelName="district" name="district_id"/>

                            </div>

                            <div class="row mt-20">
                                <x-backend.user.form.select labelName="ward" name="ward_id" />

                                <x-backend.user.form.input labelName="address" inputName="address" type="text"/>
                            </div>

                            <div class="row mt-20">
                                <x-backend.user.form.input inputName="phone" type="text" labelName='phone'/>

                                <x-backend.user.form.input inputName="description" type="text"
                                    labelName='description'/>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary mb-20">Save</button>
            </div>
        </div>
    </form>
</x-backend.dashboard.layout>
