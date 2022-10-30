const Radio = ({ id, name, label, value, onChange }) => {
    return (
        <div className="exlac-vm-radio">
            <input 
                id={id} 
                name={name} 
                type="radio" 
                value={value}
                onChange={onChange}
            />
            <label htmlFor={id}>{label}</label>
        </div>
    );
};
  
export default Radio;