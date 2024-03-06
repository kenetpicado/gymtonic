import{_ as f}from"./PrimaryButton-cbad163b.js";import{_ as b}from"./SearchComponent-5ee2bbd0.js";import{_ as g}from"./ThePaginator-16e396d2.js";import{c as d,_ as k}from"./AppLayout-95c26e89.js";import{_ as y}from"./UserInformation-09fbcbd5.js";import{T as v}from"./TableSection-0dcf2228.js";import{o as l,h as I,w as o,b as t,u as a,l as i,d as h,c as r,i as C,F as x,j as N,a as e,t as u}from"./app-3ea472c4.js";import{a as _}from"./alert-8ef5c8b5.js";import{I as S}from"./IconPencil-0bce1737.js";import"./helpers-a978ac81.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./sweetalert2.all-435f180d.js";import"./toast-523d5346.js";var $=d("history","IconHistory",[["path",{d:"M12 8l0 4l2 2",key:"svg-0"}],["path",{d:"M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5",key:"svg-1"}]]),w=d("star-filled","IconStarFilled",[["path",{d:"M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z","stroke-width":"0",fill:"currentColor",key:"svg-0"}]]),M=d("star","IconStar",[["path",{d:"M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z",key:"svg-0"}]]),z=d("weight","IconWeight",[["path",{d:"M12 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0",key:"svg-0"}],["path",{d:"M6.835 9h10.33a1 1 0 0 1 .984 .821l1.637 9a1 1 0 0 1 -.984 1.179h-13.604a1 1 0 0 1 -.984 -1.179l1.637 -9a1 1 0 0 1 .984 -.821z",key:"svg-1"}]]);const V=e("th",null,"ID",-1),B=e("th",null,"Nombre",-1),E=e("th",null,"Estrellas",-1),F=e("th",null,"Estado",-1),D=e("th",null,"Acciones",-1),H={class:"hover:bg-gray-50"},P=["onClick"],T=["onClick"],j={key:0,class:"badge-success"},A={key:1,class:"badge-gray"},W={class:"flex gap-4"},q={key:0},L=e("td",{colspan:"6",class:"text-center"},"No data to display",-1),O=[L],rt={__name:"Index",props:{customers:{type:Object,required:!0}},setup(c){const m=[{name:"Inicio",route:"dashboard.index"},{name:"Clientes",route:"dashboard.customers.index"}];return(n,G)=>(l(),I(k,{title:"Dashboard",breads:m},{default:o(()=>[t(v,null,{topbar:o(()=>[t(b,{url:n.route("dashboard.customers.index"),only:["customers"]},null,8,["url"]),t(a(i),{href:n.route("dashboard.customers.create")},{default:o(()=>[t(f,{type:"button"},{default:o(()=>[h(" Nuevo ")]),_:1})]),_:1},8,["href"])]),header:o(()=>[V,B,E,F,D]),body:o(()=>[(l(!0),r(x,null,C(c.customers.data,(s,J)=>(l(),r("tr",H,[e("td",null,u(s.id),1),e("th",null,[t(y,{user:s},null,8,["user"])]),e("td",null,[s.stars?(l(),r("span",{key:0,class:"flex text-amber-500 gap-1",onClick:p=>a(_)(s.id),role:"button"},[t(a(w),{size:"16"}),e("span",null,u(s.stars),1)],8,P)):(l(),r("span",{key:1,role:"button",onClick:p=>a(_)(s.id)},[t(a(M),{size:"16"})],8,T))]),e("td",null,[s.active_plans>0?(l(),r("span",j," Active ")):(l(),r("span",A," Inactive "))]),e("td",null,[e("div",W,[t(a(i),{href:n.route("dashboard.customers.plans.create",s.id),class:"badge-blue"},{default:o(()=>[h(" Pagar ")]),_:2},1032,["href"]),t(a(i),{href:n.route("dashboard.customers.weights.index",s.id),tooltip:"Pesos"},{default:o(()=>[t(a(z))]),_:2},1032,["href"]),t(a(i),{href:n.route("dashboard.customers.edit",s.id),tooltip:"Editar"},{default:o(()=>[t(a(S))]),_:2},1032,["href"]),t(a(i),{href:n.route("dashboard.customers.show",s.id),tooltip:"Historial"},{default:o(()=>[t(a($))]),_:2},1032,["href"])])])]))),256)),c.customers.data.length==0?(l(),r("tr",q,O)):N("",!0)]),paginator:o(()=>[t(g,{links:c.customers.links},null,8,["links"])]),_:1})]),_:1}))}};export{rt as default};