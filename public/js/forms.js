(function(){
  async function postJSON(url, payload){
    const res = await fetch(url, {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify(payload)
    });
    const data = await res.json().catch(()=>({ok:false,error:'Invalid JSON'}));
    if (!res.ok || !data.ok) throw new Error(data.error || ('HTTP '+res.status));
    return data;
  }

  function payloadFrom(form, form_type){
    const get = sel => (form.querySelector(sel)?.value || '').trim();
    const obj = { form_type, website: get('input[name="website"]') };
    const fields = form_type === 'contact'
      ? ['name','email','phone','service','address','city','zip','message','subject']
      : ['first_name','last_name','company','address','city','zip','phone','email','additional_info','how_found'];
    fields.forEach(k => {
      const el = form.querySelector(`[name="${k}"]`);
      if (el) obj[k] = (el && el.tagName === 'TEXTAREA') ? el.value.trim() : (el ? (el.value || '').trim() : '');
    });
    if (form_type === 'quote'){
      const selected = Array.from(form.querySelectorAll('input[name="services[]"]:checked')).map(c=>c.value.trim()).filter(Boolean);
      if (selected.length){ obj.services = selected; obj.service = selected.join(', '); }
    }
    return obj;
  }

  function mount(formId, form_type, alertId){
    const form = document.getElementById(formId);
    if (!form) return;
    const alertBox = document.getElementById(alertId) || form.querySelector('.alert-success');
    const submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('button');

    // Add honeypot if missing
    if (!form.querySelector('input[name="website"]')){
      const hp = document.createElement('input');
      hp.type='text'; hp.name='website'; hp.className='d-none'; hp.autocomplete='off'; hp.tabIndex=-1;
      form.prepend(hp);
    }

    form.addEventListener('submit', async (e)=>{
      e.preventDefault();
      if (alertBox) alertBox.classList.add('d-none');
      const orig = submitBtn?.textContent;
      if (submitBtn){ submitBtn.disabled=true; submitBtn.textContent='Submitting...'; }
      try {
        const payload = payloadFrom(form, form_type);
        await postJSON('/api/mail', payload);
        if (alertBox){ alertBox.classList.remove('d-none'); }
        else {
          const ok = document.createElement('div');
          ok.className='alert alert-success mt-3';
          ok.textContent='Thank you! Your request was submitted successfully.';
          form.prepend(ok);
        }
        form.reset();
      } catch (err){
        console.error(err);
        let danger = form.querySelector('.alert-danger');
        if (!danger){
          danger = document.createElement('div');
          danger.className='alert alert-danger mt-3';
          form.prepend(danger);
        }
        danger.textContent = err.message || 'Submission failed';
      } finally {
        if (submitBtn){ submitBtn.disabled=false; submitBtn.textContent=orig || 'Submit'; }
      }
    });
  }

  // Mount both forms
  mount('contactForm','contact','contactAlert');
  mount('scheduleForm','quote','quoteAlert');
})();