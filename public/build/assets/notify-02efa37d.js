import{S as o}from"./sweetalert2.all-ba9d370f.js";function u(){function e(t){o.fire({icon:"success",title:"Success",text:t,position:"top-end",toast:"true",timer:2e3,showCancelButton:!1,showConfirmButton:!1})}function n(t){o.fire({icon:"error",title:"Error",text:t,position:"top-end",toast:"true",timer:2e3,showCancelButton:!1,showConfirmButton:!1})}function r(t,i="Are you sure?"){o.fire({icon:"info",iconColor:"#4f46e5",title:"Confirm",text:i,showCancelButton:!0,confirmButtonText:"Yes. I'm sure",confirmButtonColor:"#4f46e5"}).then(s=>{s.isConfirmed&&t()})}return{success:e,error:n,confirm:r}}export{u};
