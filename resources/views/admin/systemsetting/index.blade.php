@extends('admin.layouts.app') 

@section('content') 
<style>
   /* Add custom CSS to make the background of current logo container transparent */
   .current-logo-container {
     background-color: transparent !important;
   }
</style>

<div class="wrapper">
   <div class="content-wrapper">
      <div class="content-header">
         <div class="container-fluid">
            <!-- Content Header (Page header) -->
         </div>
      </div>
      <div class="content">
         <div class="container-fluid">
            <div class="card card-outline card-info">
               <div class="card-header">
                  <h3 class="card-title">Update System Setting</h3>
               </div>
               <div class="card-body">
                  <form action="{{ route('UpdateSystemSetting', base64_encode($SystemSetting->id)) }}" method="POST" name="editCmsForm" id="editCmsForm" enctype="multipart/form-data">
                     @csrf 
                     <div class="row">
                        <div class="col-md-4 section-container">
                           <div class="card card-outline card-primary">
                              <div class="card-header">
                                 <h5 class="card-title">Logo Section</h5>
                              </div>
                              <div class="card-body">
                                 <label for="logo" class="form-label">LOGO:</label>
                                 <input type="file" class="form-control-file" name="logo" accept="image" multiple /> @error('logo') 
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror 
                                 <div class="mb-3">
                                    <label for="current_image" class="form-label">Current Logo:</label> @if($SystemSetting->logo) 
                                    <div class="row">
                                       <div class="col-md-6">
                                          <!-- Increase the column width to make the image larger -->
                                          <div class="current-logo-container">
                                             <img src="{{ asset('storage/SystemSetting/' . $SystemSetting->logo) }}" alt="Current Logo" class="current-logo">
                                          </div>
                                       </div>
                                    </div>
                                    @else 
                                    <p>No logo available</p>
                                    @endif
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-8 section-container">
                           <div class="card card-outline card-primary">
                              <div class="card-header">
                                 <h5 class="card-title">Contact Information</h5>
                              </div>
                              <div class="card-body">
                                 <label for="email" class="form-label">Email:</label>
                                 <input type="email" class="form-control" name="email" placeholder="Enter your email" value="{{ old('email', $SystemSetting->email) }}" /> 
                                 @error('email') 
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror 
                                 <label for="phone" class="form-label">Phone:</label>
                                 <input type="text" class="form-control" name="phone" placeholder="Enter your phone number" value="{{ old('phone', $SystemSetting->phone) }}" /> @error('phone') 
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror
                                 <label for="address" class="form-label">Address:</label>
                                 <textarea type="text" class="form-control" name="address" placeholder="Enter your address" value="">{{ old('address', $SystemSetting->address) }}</textarea>
                                 @error('address') 
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror 
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="card card-outline card-primary">
                              <div class="card-header">
                                 <h5 class="card-title">Social Media Links</h5>
                              </div>
                              <div class="card-body">
                                 <label for="facebook" class="form-label">Facebook Link:</label>
                                 <input type="text" class="form-control" name="facebook" placeholder="Enter Facebook link" value="{{ old('facebook', $SystemSetting->facebook) }}" /> @error('facebook') 
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror <label for="instagram" class="form-label">Instagram Link:</label>
                                 <input type="text" class="form-control" name="instagram" placeholder="Enter Instagram link" value="{{ old('instagram', $SystemSetting->instagram) }}" /> @error('instagram') 
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror <label for="linkedin" class="form-label">LinkedIn Link:</label>
                                 <input type="text" class="form-control" name="linkedin" placeholder="Enter LinkedIn link" value="{{ old('linkedin', $SystemSetting->linkedin) }}" /> @error('linkedin') 
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror <label for="twitter" class="form-label">Twitter(X) Link:</label>
                                 <input type="text" class="form-control" name="twitter" placeholder="Enter Twitter(X) link" value="{{ old('twitter', $SystemSetting->twitter) }}" /> @error('twitter') 
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- /.card-body -->
                     <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" id="updateSystemSettingBtn">Update</button>
                    </div>                    
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection