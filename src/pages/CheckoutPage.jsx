// src/pages/CheckoutPage.jsx
import { useState } from 'react';
import { Button } from '../components/Button';
import { Input } from '../components/Input';

const steps = ['Billing Info', 'Payment', 'Confirmation'];

export const CheckoutPage = () => {
  const [currentStep, setCurrentStep] = useState(0);

  const handleNext = () => {
    setCurrentStep(prev => (prev < steps.length - 1 ? prev + 1 : prev));
  };

  const handleBack = () => {
    setCurrentStep(prev => (prev > 0 ? prev - 1 : prev));
  };

  return (
    <div>
      <h1 className="text-3xl font-bold mb-8 text-center">Checkout</h1>
      <div className="w-full max-w-2xl mx-auto bg-navy-800 p-8 rounded-lg">
        <div className="mb-8">
          <div className="flex items-center justify-between">
            {steps.map((step, index) => (
              <div key={step} className={`step-item ${index <= currentStep ? 'active' : ''}`}>
                <div className="step-counter">{index + 1}</div>
                <div>{step}</div>
              </div>
            ))}
          </div>
        </div>

        {currentStep === 0 && (
          <div>
            <h2 className="text-xl font-bold mb-4">Billing Information</h2>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <Input placeholder="First Name" />
              <Input placeholder="Last Name" />
              <Input placeholder="Address" className="md:col-span-2" />
              <Input placeholder="City" />
              <Input placeholder="Zip Code" />
            </div>
          </div>
        )}

        {currentStep === 1 && (
          <div>
            <h2 className="text-xl font-bold mb-4">Payment Method</h2>
            <div className="space-y-4">
              <Input placeholder="Card Number" />
              <div className="grid grid-cols-2 gap-4">
                <Input placeholder="MM/YY" />
                <Input placeholder="CVC" />
              </div>
            </div>
          </div>
        )}

        {currentStep === 2 && (
          <div className="text-center">
            <h2 className="text-2xl font-bold mb-4">Thank you for your order!</h2>
            <p>Your purchase has been successful.</p>
          </div>
        )}

        <div className="mt-8 flex justify-between">
          {currentStep > 0 && currentStep < 2 && (
            <Button variant="secondary" onClick={handleBack}>Back</Button>
          )}
          {currentStep < 2 ? (
            <Button onClick={handleNext}>Next</Button>
          ) : (
            <div />
          )}
        </div>
      </div>
    </div>
  );
};
