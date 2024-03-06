import{_ as b}from"./PrimaryButton-cbad163b.js";import{_ as g}from"./AppLayout-95c26e89.js";import{_ as S}from"./DialogModal-b98b38c2.js";import{_ as v}from"./InputForm-daeecd40.js";import{_ as U}from"./SecondaryButton-369c6abe.js";import{f as x,T as w,o as n,h as I,w as a,b as l,d as f,t as i,u as s,c as d,i as V,F as y,j as B,a as o}from"./app-3ea472c4.js";import{_ as T}from"./UserInformation-09fbcbd5.js";import{T as j}from"./TableSection-0dcf2228.js";import{t as C}from"./toast-523d5346.js";import{_ as q}from"./SelectForm-3f762007.js";import{I as D}from"./IconPencil-0bce1737.js";import"./helpers-a978ac81.js";import"./_plugin-vue_export-helper-c27b6911.js";const E=o("div",{class:"text-2xl font-extrabold text-gray-600"},"Usuarios",-1),F=o("th",null,"ID",-1),O=o("th",null,"Nombre",-1),R=o("th",null,"Correo",-1),z=o("th",null,"Rol",-1),A=o("th",null,"Accciones",-1),G={class:"hover:bg-gray-50"},L={class:"badge-blue uppercase"},M={key:0},P=o("td",{colspan:"4",class:"text-center"},"No data to display",-1),H=[P],ue={__name:"Index",props:{users:{type:Object,required:!0},roles:{type:Object,required:!0}},setup(m){const h=m,c=x(!1),_=x(!0),N=[{name:"Inicio",route:"dashboard.index"},{name:"Usuarios",route:"dashboard.users.index"}],e=w({id:null,name:"",email:"",role:h.roles[h.roles.length-1]});function k(u){e.id=u.id,e.name=u.name,e.email=u.email,e.role=u.role,_.value=!1,c.value=!0}function $(){_.value?e.post(route("dashboard.users.store"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{C.success("Usuario creado correctamente!"),p()}}):e.put(route("dashboard.users.update",e.id),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{C.success("Usuario actualizado correctamente!"),p()}})}function p(){e.reset(),_.value=!0,c.value=!1}return(u,r)=>(n(),I(g,{title:"Usuarios",breads:N},{default:a(()=>[l(S,{show:c.value},{title:a(()=>[f(i(_.value?"Nuevo":"Editar"),1)]),content:a(()=>[l(v,{text:"Nombre",name:"name",modelValue:s(e).name,"onUpdate:modelValue":r[0]||(r[0]=t=>s(e).name=t)},null,8,["modelValue"]),l(v,{text:"Correo",name:"email",modelValue:s(e).email,"onUpdate:modelValue":r[1]||(r[1]=t=>s(e).email=t),type:"email"},null,8,["modelValue"]),l(q,{text:"Rol",name:"role",modelValue:s(e).role,"onUpdate:modelValue":r[2]||(r[2]=t=>s(e).role=t)},{default:a(()=>[(n(!0),d(y,null,V(m.roles,t=>(n(),d("option",null,i(t),1))),256))]),_:1},8,["modelValue"])]),footer:a(()=>[l(U,{onClick:p},{default:a(()=>[f(" Cancelar ")]),_:1}),l(b,{type:"button",onClick:$},{default:a(()=>[f(" Guardar ")]),_:1})]),_:1},8,["show"]),l(j,null,{topbar:a(()=>[E,l(b,{type:"button",onClick:r[3]||(r[3]=t=>c.value=!0)},{default:a(()=>[f(" Nuevo ")]),_:1})]),header:a(()=>[F,O,R,z,A]),body:a(()=>[(n(!0),d(y,null,V(m.users,(t,J)=>(n(),d("tr",G,[o("td",null,i(t.id),1),o("th",null,[l(T,{user:t},null,8,["user"])]),o("td",null,i(t.email),1),o("td",null,[o("span",L,i(t.role),1)]),o("td",null,[l(s(D),{onClick:K=>k(t),role:"button"},null,8,["onClick"])])]))),256)),m.users.length==0?(n(),d("tr",M,H)):B("",!0)]),_:1})]),_:1}))}};export{ue as default};